import React from 'react';
import HTMLFlipBook from "react-pageflip";

function Book() {
  const manualPages = [
    {
      title: "Registro de usuario",
      description: "Para comenzar a usar Equilibria, primero debes registrarte como usuario. Para ello haremos click en el botón de registro en la esquina superior derecha.",
      image: "/images/manual/registro.webp"
    },
    {
      title: "Registro de usuario",
      description: "Para registrarte en Equilibria, deberás rellenar el formulario o crear tu cuenta con Google.",
      image: "/images/manual/registro2.webp"
    },
    {
      title: "Datos personales",
      description: "Una vez registrado, podrás introducir tus datos personales para personalizar tu experiencia.",
      image: "/images/manual/datos.webp"
    },
    {
      title: "Inicio de sesión",
      description: "Si ya tienes una cuenta, puedes iniciar sesión con el botón de la esquina superior derecha.",
      image: "/images/manual/login.webp"
    },
    {
      title: "Inicio de sesión",
      description: "Aquí con tu correo y contraseña, o con tu cuenta de Google, puede acceder a tu perfil.",
      image: "/images/manual/login2.webp"
    },
    {
      title: "Editar perfil",
      description: "Una vez inciada la sesión, podrás editar tu perfil en el botón 'Editar perfil' de la pestaña 'Perfil'.",
      image: "/images/manual/perfiledit.webp"
    },
    {
      title: "Editar perfil",
      description: "Al pulsar el botón podremos cambiar los diferentes datos previamente introducidos.",
      image: "/images/manual/editarPerfil.webp"
    },
    {
      title: "Editar perfil",
      description: "También podrás editar tu foto haciendo click en el circulo de la imagen.",
      image: "/images/manual/perfilfoto.webp"
    },
    {
      title: "Planes semanales - Sin plan",
      description: "Al entrar en la página de planes semanales, veremos el siguiente botón si no tenemos plan o en el caso contrario veremos el plan generado.",
      image: "/images/manual/sinPlan.webp"
    },
    {
      title: "Chat equilibria - Generar plan",
      description: "En la pestaña de chat podrás crear tus planes semanales, desde el botón 'Generar plan'.",
      image: "/images/manual/generar.webp"
    },
    {
      title: "Chat equilibria - Generar plan",
      description: "Equilibria nos responderá con un plan generado según nuestras preferencias y restricciones. Este plan podremos descargarlo en PDF desde aquí o ir a la pestaá planes.",
      image: "/images/manual/generar2.webp"
    },
    {
      title: "Planes semanales - Ver plan",
      description: "Si accedemos a la pestaña planes después de haber generado un plan, veremos el plan generado de cada dia de la semana. Aquí también podremos descargar el plan en PDF.",
      image: "/images/manual/generar3.webp"
    },
    {
      title: "Chat equilibria - Cambiar plato",
      description: "En la pestaña de chat podrás cambiar tus platos, desde el botón 'Cambiar plato'.",
      image: "/images/manual/cambiarplato.webp"
    },
    {
      title: "Chat equilibria - Cambiar plato",
      description: "Esto abrirá una ventana emergente donde podrás seleccionar el plato que quieres cambiar.",
      image: "/images/manual/cambiarplato2.webp"
    },
    {
      title: "Chat equilibria - Intolerancias",
      description: "En la pestaña de chat podrás añadir o eliminar tus intolerancias alimentarias, desde el botón 'Intolerancias'.",
      image: "/images/manual/intolerancias.webp"
    },
    {
      title: "Chat equilibria",
      description: "Aquí podrás añadir o eliminar tus intolerancias alimentarias. También podrás ver las intolerancias que ya tienes añadidas.",
      image: "/images/manual/intolerancias2.webp"
    },
    {
      title: "",
      description: "",
      image: "/images/logo.webp"
    }
  ];

  return (
    <HTMLFlipBook
      width={500}
      height={700}
      maxShadowOpacity={0.5}
      drawShadow={true}
      showCover={true}
      size="fixed"
    >
      {/* Portada */}
      <div className="page" style={{ background: 'transparent' }}>
        <div className="react-book-page-content react-book-cover">
          <img
            src="/images/logo.webp"
            alt="Logo Equilibria"
            className="react-book-logo"
          />
          <p className="react-book-title">Manual de uso de Equilibria</p>
        </div>
      </div>

      {/* Páginas del manual */}
      {manualPages.map((page, index) => (
        <div key={index} className="react-book-page">
          <div className="react-book-page-content">
            <div className="manual-header">
              <h2 className="manual-title">{page.title}</h2>
            </div>
            <div className="manual-body">
              <p className="manual-description">{page.description}</p>
              <img
                src={page.image}
                alt={page.title}
                className="manual-image"
              />
            </div>
          </div>
        </div>
      ))}
    </HTMLFlipBook>
  );
}

export default Book;
