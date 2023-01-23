resource "azurerm_resource_group" "michimaker" {
  name     = var.rg_name
  location = var.location
  tags     = { enviroment = "dev" }
}


# Generate random value for the login password
resource "random_password" "password" {
  length           = 20
  lower            = true
  min_lower        = 1
  min_numeric      = 1
  min_special      = 1
  min_upper        = 1
  numeric          = true
  override_special = "_"
  special          = true
  upper            = true
}


# Manages the MySQL Flexible Server
resource "azurerm_mysql_flexible_server" "default" {
  location                     = azurerm_resource_group.michimaker.location
  name                         = var.server_name
  resource_group_name          = azurerm_resource_group.michimaker.name
  administrator_login          = var.login_name
  administrator_password       = random_password.password.result
  backup_retention_days        = 7
  geo_redundant_backup_enabled = false
  sku_name                     = "B_Standard_B1ms"
  version                      = "8.0.21"
  zone                         = "1"

  maintenance_window {
    day_of_week  = 0
    start_hour   = 8
    start_minute = 0
  }
  storage {
    iops    = 360
    size_gb = 20
  }
}

resource "azurerm_mysql_flexible_server_firewall_rule" "firewall_rule" {
  name                = "everywhere"
  resource_group_name = azurerm_resource_group.michimaker.name
  server_name         = azurerm_mysql_flexible_server.default.name
  start_ip_address    = chomp(data.http.myip.response_body)
  end_ip_address      = chomp(data.http.myip.response_body)
}

resource "azurerm_mysql_flexible_database" "michimaker" {
  name                = "michimakerdb"
  resource_group_name = azurerm_resource_group.michimaker.name
  server_name         = azurerm_mysql_flexible_server.default.name
  charset             = "utf8"
  collation           = "utf8_unicode_ci"
  provisioner "local-exec"{
    command = "mysql --host=${azurerm_mysql_flexible_server.default.fqdn} --database=${self.name} --user=${azurerm_mysql_flexible_server.default.administrator_login} --password=${azurerm_mysql_flexible_server.default.administrator_password} --ssl-ca=DigiCertGlobalRootCA.crt.pem < ../datamodel/schema.sql"
  }
}

data "http" "myip" { 
    url = "http://ifconfig.me/ip"
    }