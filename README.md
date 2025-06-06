# 1. Introducción

Desde mediados del siglo XX, la sociedad ha experimentado un creciente interés por el bienestar físico y la salud integral, siendo la nutrición uno de los pilares fundamentales de este cambio. A medida que el conocimiento científico ha avanzado, también lo ha hecho la comprensión de la relación entre la alimentación y la prevención de enfermedades crónicas como la obesidad, la diabetes, las enfermedades cardiovasculares o los trastornos digestivos.

En las últimas décadas, y especialmente con el auge de la tecnología y la digitalización, ha surgido una nueva necesidad: personalizar la nutrición en función de las características y condiciones individuales de cada persona. Factores como la edad, el peso, la estatura, el nivel de actividad física, e incluso las intolerancias alimentarias, influyen de manera directa en las necesidades nutricionales de cada individuo.

Este contexto ha impulsado el desarrollo de herramientas digitales orientadas a la salud y al bienestar. Aplicaciones móviles, plataformas web y asistentes virtuales se han convertido en aliados clave para mejorar la alimentación diaria, fomentar hábitos saludables y realizar un seguimiento más riguroso del progreso personal.

## 1.1 Sobre este proyecto

En este proyecto se plantea el desarrollo de una aplicación web inteligente orientada a la nutrición y la salud, basada en fuentes fiables como la Organización Mundial de la Salud (OMS), el Ministerio de Sanidad de España y la Fundación Española de Nutrición (FEN). Esta app permitirá generar planes alimenticios semanales adaptados, calcular el Índice de Masa Corporal (IMC), recomendar ejercicios físicos adecuados, y ofrecer una experiencia interactiva mediante inteligencia artificial.

Con un enfoque moderno y personalizado, esta plataforma no solo busca mejorar la calidad de vida de sus usuarios, sino también fomentar una mayor conciencia sobre la importancia de una alimentación equilibrada y una vida activa.

## 1.2 Control de versiones

Para este proyecto se ha utilizado **Git** como sistema de control de versiones y **GitHub** como plataforma de alojamiento del repositorio.

Git permite registrar todos los cambios realizados en el código, facilitando el seguimiento, la corrección de errores y el trabajo con distintas versiones del proyecto. Gracias al uso de ramas, es posible trabajar en nuevas funcionalidades sin afectar la versión principal.

GitHub complementa este flujo permitiendo almacenar el código en la nube, colaborar fácilmente, realizar copias de seguridad automáticas y documentar el desarrollo. Además, ofrece herramientas para organizar tareas, revisar código y mantener un control total del proyecto desde cualquier lugar.

El uso de estas herramientas garantiza un desarrollo más ordenado, seguro y profesional.

## 1.3 Licencia de uso

Este proyecto está distribuido bajo la licencia **CC BY-NC (Atribución-No Comercial)**.

La licencia CC BY-NC permite que cualquier persona utilice, modifique y distribuya el contenido, siempre que sea con fines no comerciales. Esto significa que no se puede usar para generar ingresos directamente del proyecto o sus derivados. Además, se debe dar crédito adecuado al autor original cuando se utilice el proyecto, en cualquier formato o medio.

Este tipo de licencia busca fomentar el uso y la colaboración del proyecto para fines educativos o de investigación, sin permitir su explotación comercial.

# 2. Análisis del problema

## 2.1 Introducción al problema

En los últimos años, los problemas relacionados con una alimentación inadecuada y el sedentarismo se han incrementado notablemente, generando un aumento en enfermedades como la obesidad, la diabetes tipo 2 o trastornos digestivos. Muchas personas desconocen cómo alimentarse correctamente o cómo adaptar su dieta según sus necesidades específicas, intolerancias o condiciones físicas. Además, la desmotivación, la falta de seguimiento personalizado y la dificultad para integrar hábitos saludables en la rutina diaria agravan esta situación.

Existe una necesidad creciente de herramientas que permitan orientar, personalizar y acompañar a los usuarios en la mejora de su salud y bienestar, a través de la tecnología y el acceso a información confiable y personalizada.

## 2.2 Antecedentes

Actualmente existen numerosas aplicaciones enfocadas en la nutrición, el conteo de calorías o el ejercicio físico, como **MyFitnessPal**, **Yazio** o **Lifesum**. Sin embargo, muchas de estas aplicaciones presentan limitaciones como:

- Falta de personalización según intolerancias (ej. celiaquía, intolerancia a la lactosa).
- Interfaz poco intuitiva o excesivamente técnica.
- No combinan en profundidad el plan nutricional con la actividad física.
- No ofrecen una interacción fluida mediante inteligencia artificial.
- Requieren pagos para acceder a funciones clave.

Por otro lado, fuentes oficiales como la OMS, el Ministerio de Sanidad y la Fundación Española de Nutrición (FEN) insisten en la importancia de una alimentación adaptada a cada individuo, promoviendo hábitos saludables desde edades tempranas.

## 2.3 Objetivos

Desarrollar una aplicación web interactiva que proporcione planes de alimentación y ejercicio personalizados, utilizando inteligencia artificial, y adaptados a las características físicas y necesidades nutricionales de cada usuario.

### 2.3.1 Objetivos específicos

- Crear un chatbot basado en IA que genere planes semanales personalizados.
- Calcular el IMC de cada usuario a partir de sus datos físicos.
- Permitir descargar el plan nutricional en formato PDF.
- Integrar un sistema de seguimiento y estadísticas del progreso.
- Incluir funciones de reconocimiento de alimentos mediante imágenes.
- Desarrollar un sistema de logros y recompensas para mejorar la motivación.
- Implementar autenticación, incluyendo acceso con Google.
- Adaptar la app a distintos idiomas y ofrecer modo oscuro.
- Basarse en fuentes oficiales y confiables de salud y nutrición.

## 2.4 Requisitos

### 2.4.1 Funcionales

La plataforma debe permitir:

- Registro y autenticación de usuarios (incluyendo Google).
- Introducción de datos físicos (peso, altura, edad).
- Cálculo del IMC.
- Generación de plan alimenticio semanal personalizado.
- Descarga del plan en formato PDF.
- Registro de progreso y estadísticas semanales.
- Recomendaciones de ejercicio físico.
- Subida de imágenes de alimentos para reconocimiento por IA.
- Sistema de logros y recompensas.

### 2.4.2 No funcionales

La aplicación deberá:

- Tener una interfaz intuitiva, limpia y responsive.
- Ofrecer modo oscuro y soporte multilingüe.
- Cargar información de forma fluida y rápida.
- Garantizar la privacidad de los datos del usuario.

## 2.5 Recursos

### 2.5.1 Software

| Tecnología       | Descripción |
|------------------|-------------|
| Laravel          | Framework backend en PHP. Gestiona rutas, controladores, lógica y seguridad. |
| Blade            | Motor de plantillas de Laravel. Permite crear vistas dinámicas y reutilizables. |
| jQuery           | Librería JavaScript para manipular el DOM y manejar eventos. |
| Bootstrap        | Framework CSS para diseño responsive y componentes predefinidos. |
| Tailwind CSS     | Framework de utilidades CSS para aplicar estilos de forma rápida y personalizada. |
| MySQL            | Sistema de gestión de bases de datos relacional. |
| PhpMyAdmin       | Interfaz web para gestionar MySQL. |
| OpenAI API       | Permite usar IA para generar planes nutricionales y responder al usuario. |
| OpenFoodFacts API| Proporciona información nutricional real de alimentos. |
| DomPDF           | Genera archivos PDF desde HTML. |
| Figma            | Herramienta de diseño de interfaces. |
| Trello           | Gestión de tareas y planificación del desarrollo. |
| Uiverse.io       | Componentes visuales listos para usar. |
| AOS              | Biblioteca de animaciones al hacer scroll. |
| GSAP             | Librería de animaciones JavaScript. |
| Lucidchart       | Herramienta de diagramación web. |

### 2.5.2 Hardware

Requerimientos mínimos:

- **RAM**: 4–8 GB.
- **Procesador**: Multinúcleo (Intel i5 o superior).
- **Sistema Operativo**: Windows, macOS o Linux.

Para pruebas móviles:

- **Smartphones** con Android e iOS para verificar compatibilidad y diseño responsive.