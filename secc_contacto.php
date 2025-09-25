
        <!--========================================================== -->
                                <!-- SECCION CONTACTOS-->
        <!--========================================================== -->

        <section id="seccion-contacto1" class="h-25 my-5 "></section>   
        <section id="seccion-contacto" class="border-bottom border-secondary border-2 mt-5">
          <div id="bg-contactos">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#2A7BBE" fill-opacity="1" d="M0,32L120,42.7C240,53,480,75,720,74.7C960,75,1200,53,1320,42.7L1440,32L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"></path></svg>
          </div>

           <div class="container  border-top border-primary " style="max-width: 600px" id="contenedor-formulario">
              <div class="text-center mb-4" id="titulo-formulario">
                <div>
                  <img src="img/iconossvg/contacto_form.svg" class="img-fluid" alt="surglass" />
                  
                </div>
                <h2>Contactanos</h2>
                <h3 class="fs-4">Escribenos y hazte cliente.</h3>
                <p class="fs-6">Accederas a la plataforma de precios.  </p>
              </div>

              <form  id="contactform" action="contact/contact.php" method="post">     

                    <div class="mb-3">            
                      <input type="input" class="form-control" id="name" name="name" placeholder="Tu nombre">
                    </div>
                
                    <div class= "mb-3">           
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
          
          </div>
              
        </section>