FROM node:lts-alpine as stage-dev
WORKDIR /app
ARG FOLDER_FRONT
COPY ${FOLDER_FRONT}/package*.json ./
RUN npm install
COPY ${FOLDER_FRONT} .

FROM stage-dev as stage-build
RUN npm run build

FROM nginx:stable-alpine
WORKDIR /app
COPY --from=stage-build /app/dist ./
CMD ["nginx"]
EXPOSE 80
