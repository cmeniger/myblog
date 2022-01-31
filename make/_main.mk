define m-docker
	cd docker && docker $(1)
endef

define m-docker-compose
	cd docker && docker-compose $(1)
endef

define m-docker-back-exec
	@$(call m-docker, exec -it app_back_dev $(1))
endef

define m-docker-back-nginx-exec
	@$(call m-docker, exec -it app_back $(1))
endef

define m-docker-front-exec
	@$(call m-docker, exec -it app_front_dev $(1))
endef

define m-docker-front-nginx-exec
	@$(call m-docker, exec -it app_front $(1))
endef

define m-docker-mysql-exec
	@$(call m-docker, exec -it mysql $(1))
endef

define m-back
	@$(call m-docker-back-exec, /bin/sh -c "$(1)")
endef

define m-front
	@$(call m-docker-front-exec, /bin/sh -c "$(1)")
endef
