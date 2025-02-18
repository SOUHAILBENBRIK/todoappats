FROM node:22.13.0

# Set working directory
WORKDIR /app

# Copy package.json and install dependencies
COPY package.json package-lock.json ./
RUN npm install

# Copy application files
COPY . .

# Expose port for Vite
EXPOSE 5173

# Start the development server
CMD ["npm", "run", "dev"]
