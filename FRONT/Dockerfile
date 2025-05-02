# Utiliser une image de base officielle Node.js
FROM node:22 AS build-stage
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Utiliser une image de base Nginx pour servir les fichiers statiques
FROM nginx:alpine AS production-stage
COPY --from=build-stage /app/dist /usr/share/nginx/html
COPY nginx.conf /etc/nginx/conf.d/default.conf
RUN chmod -R 775 /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]