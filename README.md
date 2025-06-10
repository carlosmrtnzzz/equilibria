# 🥗 EQUILIBRIA

**Proyecto Integrado - Desarrollo de Aplicaciones Web**  
**Autor:** Carlos Martínez Jiménez  
**Centro:** I.E.S. Fuengirola Nº1  
**Año:** 2025

---

## 🎯 Descripción

**Equilibria** es una aplicación web inteligente enfocada en la nutrición personalizada y la promoción de hábitos saludables. Utiliza **inteligencia artificial** y **gamificación** para generar planes alimenticios adaptados, calcular el IMC del usuario, y fomentar la adherencia mediante recompensas y desafíos.

---

## 🛠️ Tecnologías Utilizadas

- **Backend:** Laravel (PHP), MySQL, PHPUnit
- **Frontend:** React, Tailwind CSS, GSAP
- **Utilidades:** OpenAI API, DomPDF, Figma
- **Gestión del proyecto:** Git, GitHub, Trello
- **Admin Panel:** Filament

---

## 📦 Instalación

**Requisitos:**

- PHP ≥ 8.1  
- Composer  
- Node.js y npm  
- MySQL  

**Pasos:**

```bash
git clone https://github.com/carlosmrtnzzz/equilibria.git .
composer install
npm install
cp .env.example .env
# Editar el archivo .env con tus datos de conexión y claves API
php artisan migrate
php artisan db:seed
npm run dev:all
