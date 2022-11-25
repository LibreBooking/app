#!/bin/sh

if ! [ -f config/config.php ]; then \
  if [ "$LB_ENV" = "production" ]; then cp config/config.dist.php config/config.php; fi; \
  if [ "$LB_ENV" = "dev" ]; then cp config/config.devel.php config/config.php; fi; \
  echo '$conf["settings"]["database"]["user"] = ' "'$DB_USER';" >>config/config.php; \
  echo '$conf["settings"]["database"]["password"] = ' "'$DB_PASSWORD';" >>config/config.php; \
  echo '$conf["settings"]["database"]["hostspec"] = ' "'$DB_HOST';" >>config/config.php; \
  echo '$conf["settings"]["database"]["name"] = ' "'$DB_DATABASE';" >>config/config.php; \
  echo '$conf["settings"]["install.password"] = ' "'$INSTALL_PASSWORD';" >>config/config.php; \
  echo '$conf["settings"]["sript.url"] = ' "'$SCRIPT_URL';" >>config/config.php; \
  echo '$conf["settings"]["admin.email"] = ' "'$ADMIN_EMAIL';" >>config/config.php; \
fi

apache2-foreground
