docker-install: ##@docker Install docker containers
	$(call m-docker-compose, up -d --build)

docker-build: ##@docker Build docker containers
	$(call m-docker-compose, build)

docker-ps: ##@docker List docker containers
	$(call m-docker-compose, ps)

docker-start: ##@docker&c Start docker containers, use c=xxx for specific container
	$(call m-docker-compose, start $(c))

docker-stop: ##@docker&c Stop docker containers, use c=xxx for specific container
	$(call m-docker-compose, stop $(c))

docker-rm: ##@docker&c Remove containers, use c=xxx for specific container
	$(call m-docker-compose, stop $(c))
	$(call m-docker-compose, rm $(c))

docker-restart: ##@docker&c Restart (stop + start) docker containers, use c=xxx for specific container
	$(MAKE) docker-stop c=$(c)
	$(MAKE) docker-start c=$(c)

docker-cp: ##@docker&c|s|t Copy file in container (c=container, s=source, t=target)
	$(call m-docker, cp $(s) $(c):$(t))

docker-cp-back: ##@docker&s|t Copy file in container back (s=source, t=target)
	$(MAKE) docker-cp c=app_back s=$(s) t=$(t)

docker-cp-front: ##@docker&s|t Copy file in container front (s=source, t=target)
	$(MAKE) docker-cp c=app_front s=$(s) t=$(t)
