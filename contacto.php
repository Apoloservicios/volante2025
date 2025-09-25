<section class="w-100  bg-light mb-5 mt-5" id="section_contacto">
  <div class="container mt-5 bg-ligh roboto-bold" id="form_contacto">

    <h1 class="roboto-bold py-4 p-5 text_sur_primario fa-4x ">Contactanos</h1>

    <div class="row">
      <div class="col-lg-6 d-flex justify-content-center">
        <!-- Información de contacto -->



        <div id="formulario_caja">
          <div class="text-center mb-4" id="titulo-formulario">

          <h3 class="fs-3">Escribenos y hazte cliente.</h3>
          <p class="fs-6">Accederas a la plataforma de precios.  </p>
          </div>




          <form id="contactform" action="contact/contact.php" method="post">

            <div class="mb-3">
              <input type="input" class="form-control" id="name" name="name" placeholder="Tu nombre">
            </div>

            <div class="mb-3">
              <input type="email" class="form-control" id="email" name="email" placeholder="correo@correo.com">
            </div>
            <div class="mb-3">
              <input type="input" class="form-control" id="msg_subject" name="msg_subject" placeholder="Asunto">
            </div>

            <div class="mb-3">
              <input type="tel" class="form-control" name="phone" id="phone" placeholder="Teléfono">
            </div>

            <div class="mb-3">
              <textarea class="form-control" name="message" id="message" rows="4"></textarea>
            </div>

            <div class="mb-3">
              <button type="submit" class=" btn btn-primary w-100 fs-5">Enviar Mensaje</button>
            </div>
          </form>
          <div id="alertPlaceholder" class="mt-3"></div>

        </div>
      </div>
      <div class="col-lg-6  d-flex justify-content-center mx-auto">

        <div class="col px-5" id="map-container">

          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3283.1850082733367!2d-68.31899697575705!3d-34.624764724102455!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9679a81c846acfe1%3A0xd12cd2519bfca165!2sPatricias%20Mendocinas%20360%2C%20M5602BSC%20San%20Rafael%2C%20Mendoza!5e0!3m2!1ses-419!2sar!4v1630186290167!5m2!1ses-419!2sar" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

        </div>
      </div>
    </div>
  </div>
  


</section>