# Use Node.js 22 as base image
FROM node:22.13.0

# Install pnpm globally
RUN npm install -g pnpm

# Set working directory
WORKDIR /app

# Copy package.json and pnpm-lock.yaml first for better caching
COPY package.json pnpm-lock.yaml ./

# Install dependencies using pnpm
RUN pnpm install --frozen-lockfile

# Copy application files
COPY . .

# Expose port for Vite
EXPOSE 5173

# Start the development server
CMD ["pnpm", "dev"]
