ssh-back: ##@ssh Start bash session for container back
	$(call m-docker-back-exec, /bin/sh)

ssh-back-nginx: ##@ssh Start bash session for container back (nginx)
	$(call m-docker-back-nginx-exec, /bin/sh)

ssh-front: ##@ssh Start bash session for container front
	$(call m-docker-front-exec, /bin/sh)

ssh-front-nginx: ##@ssh Start bash session for container front (nginx)
	$(call m-docker-front-nginx-exec, /bin/sh)

ssh-mysql: ##@ssh Start bash session for container mysql
	$(call m-docker-mysql-exec, /bin/sh)
