variable "rg_name" {
  type    = string
  default = "michimaker"
  validation {
    condition     = can(regex("^[-\\w\\.\\(\\)]{1,90}$", var.rg_name)) && can(regex("[-\\w\\(\\)]+$", var.rg_name))
    error_message = "Resource group names must be between 1 and 90 characters and can only include alphanumeric, underscore, parentheses, hyphen, period (except at end)."
  }
}

variable "location" {
  type    = string
  default = "eastus"
  validation {
    condition     = contains(["japaneast", "eastus"], lower(replace(var.location, " ", "")))
    error_message = "Location is not valid."
  }
}

variable "server_name" {
  type    = string
  default = "michimaker-pgsql2"
  validation {
    condition     = can(regex("^[-0-9a-z]{3,63}$", var.server_name)) && can(regex("[0-9a-z]+$", var.server_name)) && can(regex("^[0-9a-z]+", var.server_name))
    error_message = "The name must be between 3 and 63 characters, can only contain lowercase letters, numbers, and hyphens. Must not start or end with a hyphen."
  }
}




#  validation {    condition     = length(var.allow_ip_list) == 0 || alltrue([for v in var.allow_ip_list : can(regex("^(([2]([0-4][0-9]|[5][0-5])|[0-1]?[0-9]?[0-9])[.]){3}(([2]([0-4][0-9]|[5][0-5])|[0-1]?[0-9]?[0-9]))(\/([0-9]|[12][0-9]|3[0-2]))?$", v))])    error_message = "Invalid IP or IP range in CIDR format found in the list."  }
# validation {    condition     = can(regex("^[-\\w\\.]{1,80}$", var.private_subnet_name)) && can(regex("^[0-9a-zA-Z]+", var.private_subnet_name)) && can(regex("[\\w]+$", var.private_subnet_name))    error_message = "The name for the subnet must begin with a letter or number, end with a letter, number or underscore, and may contain only letters, numbers, underscores, periods, or hyphens."  }