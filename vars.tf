variable "rg_name" {
  type    = string
  default = "michimaker"
}

variable "location" {
  type    = string
  default = "japaneast"
  validation {
    condition     = contains(["japaneast", "eastus"], var.location)
    error_message = "Location is not valid."
  }
}

variable "server_name" {
  type    = string
  default = "michimaker-pgsql"
  validation {
    condition     = length(var.server_name) > 8
    error_message = "Server name is too short. Minimum length is 9 characters. Current length is ${length(var.server_name)} characters."
  }
}

variable "login_name" {
  type    = string
  default = "michimaker_admin"
}