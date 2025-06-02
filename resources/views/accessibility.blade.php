<x-layouts.base metaTitle="Accesibilidad" tituloSeccion="Accesibilidad">

    <div class="card shadow-sm h-100 mb-3" aria-label="Introducción sobre accesibilidad del sitio"
        title="Introducción a la accesibilidad">
        <div class="card-body d-flex flex-column justify-content-between p-5">
            <p class="mb-4" style="font-size: 1.1rem">
                En cumplimiento con lo dispuesto para los sitios web de las Administraciones Públicas por la Ley de
                Servicios de la Sociedad de la Información y el Comercio Electrónico, y en nuestro compromiso por
                garantizar la accesibilidad de nuestros contenidos, se ofrece la siguiente declaración de accesibilidad:
            </p>

            <h3 class="h4 mt-4 fw-semibold border-bottom pb-2">Declaración de Accesibilidad</h3>
            <p>
                Este sitio web se compromete a ser accesible de conformidad con el <a
                    href="https://www.boe.es/buscar/act.php?id=BOE-A-2018-12699">Real Decreto 1112/2018, de 7 de
                    septiembre</a>, sobre accesibilidad de los sitios web y aplicaciones para dispositivos móviles del
                sector
                público.
            </p>
            <p>
                El objetivo es garantizar un acceso universal a la información mediante herramientas web no excluyentes,
                que mantengan la mayor accesibilidad posible. Cualquier persona debe poder consultar y utilizar los
                contenidos publicados en este portal, independientemente de:
            </p>
            <ul>
                <li>Sus circunstancias personales (discapacidad, diversidad funcional, edad avanzada).</li>
                <li>Las limitaciones derivadas de su entorno o del contexto de uso (velocidad de conexión, condiciones
                    ambientales, dispositivo).</li>
            </ul>

            <p>La presente declaración de accesibilidad se aplica al sitio web <a
                    href="{{ route('user.index') }}">www.nombredeldominio.es</a>.</p>

            <h4 class="h5 mt-4 fw-semibold border-bottom pb-2">Situación de cumplimiento</h4>
            <p>
                Tras la autoevaluación llevada a cabo, se determina que este sitio web es no conforme con el Real
                Decreto 1112/2018, de 7 de septiembre, debido a la falta de conformidad de los aspectos que se indican a
                continuación.
            </p>
        </div>
    </div>

    <div class="card shadow-sm h-100 mb-3" aria-label="Detalles sobre contenidos no accesibles"
        title="Contenidos no accesibles">
        <div class="card-body d-flex flex-column justify-content-between p-5">
            <h3 class="h4 mt-4 fw-semibold border-bottom pb-2">Contenido no accesible</h3>
            <p>
                Existen determinados contenidos intrínsecamente no accesibles a lo largo de este portal, como pueden ser
                los mapas o los vídeos, pero en todos los casos se ha intentado proporcionar una alternativa accesible.
                El contenido que se recoge a continuación no es accesible por los siguientes motivos:
            </p>
            <ul>
                <li>Falta de conformidad con Real Decreto 1112/2018, como reproductores de vídeo sin subtítulos
                    disponibles.</li>
                <li>Imágenes sin texto alternativo.</li>
                <li>Falta de audiodescripción o medios alternativos en vídeos pregrabados.</li>
                <li>Problemas de contraste en algunos elementos.</li>
                <li>Inadecuada descripción de enlaces o botones.</li>
                <li>Problemas de navegación por teclado no accesibles.</li>
            </ul>

            <h4 class="h5 mt-4 fw-semibold border-bottom pb-2">Carga desproporcionada</h4>
            <p>
                No aplica en este caso. El contenido no entra dentro del ámbito de la legislación aplicable, y algunos
                archivos o contenidos podrían no cumplir con todos los requisitos de accesibilidad debido a la fecha de
                su publicación.
            </p>
        </div>
    </div>

    <div class="card shadow-sm h-100 mb-3" aria-label="Información para comunicaciones y contacto"
        title="Comunicaciones y contacto sobre accesibilidad">
        <div class="card-body d-flex flex-column justify-content-between p-5">
            <h3 class="h4 mt-4 fw-semibold border-bottom pb-2">Comunicaciones y datos de contacto</h3>
            <p>
                Puede realizar comunicaciones sobre requisitos de accesibilidad a través de los siguientes medios:
            </p>
            <ul>
                <li><a href="{{ route('contact') }}"><strong>Formulario Web</strong></a></li>
                <li><strong>Teléfono:</strong> 012</li>
            </ul>
            <p>
                La comunicación de incidencias técnicas o errores debe realizarse a través de los canales de Atención al
                Usuario.
            </p>

            <h4 class="h5 mt-4 fw-semibold border-bottom pb-2">Procedimiento de aplicación</h4>
            <p>
                Puede solicitar, en formato accesible, información que no cumpla con los requisitos de accesibilidad,
                bien por estar excluida, bien por estar exenta por carga desproporcionada o formular una queja por
                incumplimiento de los requisitos de accesibilidad.
            </p>
            <a href="{{ route('contact') }}">
                Solicitud de información accesible o quejas sobre accesibilidad de los sitios web y aplicaciones para
                dispositivos móviles.
            </a>
            <h4 class="h5 mt-4 fw-semibold border-bottom pb-2">Reclamaciones</h4>
            <p>
                Si una vez realizada una solicitud de información accesible o queja, ésta hubiera sido desestimada,
                no estuviera de acuerdo con la decisión adoptada, o la respuesta no cumpliera los requisitos exigidos,
                la persona interesada podrá iniciar una reclamación. También se podrá presentar en el caso de que
                haya trascurrido el plazo de veinte días hábiles sin haber obtenido respuesta.
            </p>
            <a href="{{ route('contact') }}">
                Reclamación sobre requisitos de accesibilidad de los sitios web y aplicaciones para dispositivos móviles
            </a>
        </div>
    </div>

    <div class="card shadow-sm h-100 mb-3" aria-label="Historial de revisiones de accesibilidad"
        title="Historial de revisiones">
        <div class="card-body d-flex flex-column justify-content-between p-5">

            <h3 class="h4 mt-4 fw-semibold border-bottom pb-2">Historial de revisiones</h3>
            <ul>
                <li>15/04/2025 Informe de accesibilidad: Nivel de conformidad A y AA.</li>
                <li>11/04/2024 Informe de accesibilidad: Nivel de conformidad A y AA.</li>
                <li>20/12/2023 Informe de accesibilidad: Nivel de conformidad A y AA.</li>
            </ul>

            <p class="mt-3 text-end">Última actualización: {{ date('d/m/Y') }}</p>
        </div>
    </div>

</x-layouts.base>
