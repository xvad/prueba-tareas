FROM node:22

WORKDIR /app

# Copiamos los archivos de configuración
COPY package*.json ./

# Instalamos nodemon como dependencia de desarrollo
RUN npm install && npm install --save-dev nodemon

# Copiamos el resto del código
COPY . .

# Exponemos el puerto del servidor de desarrollo
EXPOSE 3000

# Ejecutamos nodemon apuntando al script de desarrollo
CMD ["npx", "nodemon", "--watch", ".", "--exec", "npm run dev", "--legacy-watch"]
