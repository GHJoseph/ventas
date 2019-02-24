<html>

    <head>
        <title>Laravel 5.5 Ajax Request example</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

        <meta name="csrf-token" content="{{ csrf_token() }}" />

    </head>

    <body>

        <div class="container">

            <h1>Laravel 5.5 Ajax Request example</h1>

            <table class="table table-bordered">
                <tr id="Fila1">
                    <td id="IDE"><strong>ID</strong></td>
                    <td id="Hour"><strong>Horas</strong></td>
                    <td id="Horario"><strong>Horario</strong></td>
                    <td id="Horario"><strong>Horario</strong></td>
                    <td id="Horario"><strong>Horario</strong></td>
                    <td id="Horario"><strong>Horario</strong></td>
                    <td id="Horario"><strong>Horario</strong></td>
                </tr>
                <?php foreach ($test as $usuario) { ?>
                    <tr id="Fila3">                            
                        <td id="Ubicacion">1</td>
                        <td id="id"><?= $usuario->id ?></td>
                        <td id="Nombre"><?= $usuario->Nombre ?></td>
                        <td id="Password"><?= $usuario->Password ?></td>
                        <td id="Email"><?= $usuario->Email ?></td>
                        <td id="Fila"><?= $usuario->Fila ?></td> 
                        <td id="Columna"><?= $usuario->Columna ?></td>                                                                                    
                    </tr>                    
                <?php } ?>

                <tr id="Fila2">
                    <td id="1">2</td>
                    <td id="Horas" onclick="posicion(this)"></td>
                    <td id="3"></td>                            
                    <td id="4"></td>                            
                    <td id="5"></td>                            
                    <td id="5"></td>                            
                    <td id="5"></td>                            
                </tr>               

            </table>

            <form>

                <div class="form-group">

                    <label>Name:</label>

                    <input type="text" name="name" class="form-control" placeholder="Name" required="">

                </div>

                <div class="form-group">

                    <label>Password:</label>

                    <input type="password" name="password" class="form-control" placeholder="Password" required="">

                </div>

                <div class="form-group">

                    <strong>Email:</strong>

                    <input type="email" name="email" class="form-control" placeholder="Email" required="">

                </div>
                <div>
                    <table>
                        <tr id="Fila1">
                            <td id="Curso"><strong>Curso</strong></td>
                            <td id="Horas"><strong>Horas</strong></td>
                            <td id="Horario"><strong>Horario</strong></td>
                        </tr>

                        <tr id="Fila2">
                            <td id="CSS" onclick="calcular(this)">CSS</td>
                            <td id="20">20</td>
                            <td id="16">16:00 - 20:00</td>
                        </tr>

                        <tr id="Fila3">
                            <td id="HTML">HTML</td>
                            <td id="30">30</td>
                            <td id="20">16:00 - 20:00</td>
                        </tr>
                    </table>
                </div>

                <div class="form-group">

                    <button class="btn btn-success btn-submit">Submit</button>

                </div>

            </form>

        </div>

    </body>

    <script type="text/javascript">

        function posicion(element) {

            columna = document.getElementById('Columna').value;
            fila = document.getElementById('Fila').value;
            if (columna !== '' && fila !== '') {
                if( $("#Fila2").id === document.getElementById('Fila').value){
                    
                  var Ubicacion = document.getElementById('Columna').value;
                  alert(Ubicacion);
    //                    document.getElementById("Horas").innerHTML = document.getElementById("Nombre").value;
                }
            }
        }


        var columna;
        var fila;

        function calcular(elemento)
        {
            columna = elemento.id;
            fila = elemento.parentNode.id;
        }

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });



        $(".btn-submit").click(function (e) {

            e.preventDefault();



            var name = $("input[name=name]").val();

            var password = $("input[name=password]").val();

            var email = $("input[name=email]").val();



            $.ajax({

                type: 'POST',

                url: 'test',

                data: {name: name, password: password, email: email, fila: fila, columna: columna},

                success: function (data) {

                    alert(data.success);

                }

            });



        });

    </script>

</html>
