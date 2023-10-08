<?php
session_start();
$logged=$_SESSION['logged'];

if(!$logged){
    //echo "ingreso no autorizado";
 
    echo '<meta http-equiv="refresh" content="1; url=login.php">';
 
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <img src="./img/icon-menu.svg" id="hamburguer" alt="">
    <div id="container">
        <div id="barral">
            <h1>Menú</h1>
            <h3>Ítems</h3>
            <h4>Main</h4>
            <ul id="menu">
                <li><a href="./index.html">Principal</a></li>
            </ul>
        </div>
        <div id="content">
            <header>
                <div id="encabezado">
                    <div id="logo">
                        <img src="./logo-huertas.jpeg" alt="logo">
                    </div>
                    <h1>SISTEMA DE CONTROL</h1>
                    <div id="escudo">
                        <img src="./img/ESCUDO.jpg" alt="Escudo Nicolás Gaviria">
                    </div>
                </div>
            </header>
            <div id="cards">
                <div class="card">
                    <div class="icon">
                        <img src="./img/hygrometer.png" alt="">
                    </div>
                    <div class="textos">
                        <p id="display_huma" class="tooltip" title="En esta caja puedes observar la humedad de suelo actual">--</p>
                        <span>%</span>
                        <h4>Humedad de suelo</h4>
                    </div>
                    
                </div>
                <div class="card">
                    <div class="icon">
                        <img src="./img/itemperatures.png" alt="">
                    </div>
                    <div class="textos">
                        <p id="display_temp" class="tooltip" title="En esta caja puedes observar la temperatura actual">--</p>
                        <span>°C</span>
                        <h4>Temperatura</h4>
                    </div>
                </div>
                <div class="card">
                    <div class="icon">
                        <img src="./img/moisture.png" alt="">
                    </div>
                    <div class="textos">
                        <p id="display_hums" class="tooltip" title="En esta caja puedes observar la humedad ambiental actual">--</p>
                        <span>%</span>
                        <h4>Humedad ambiental</h4>
                        
                    </div>
                </div>
            </div>

            <div id="switches">
                <div class="switch">
                    <div class="caja tooltip" title="Con este elemento activamos el riego">
                        <h4 style="color: black;">Relay 1</h4>
                        <input type="checkbox" class="relay_1"  onchange="relay_1()" id="relay_1">
                        <label for="relay_1"></label>
                    </div>
                </div>
                <div class="switch">
                    <div class="caja">
                        <h4 style="color: black;">Relay 2</h4>
                        <input type="checkbox" class="relay_2" onchange="relay_2()" id="relay_2">
                        <label for="relay_2"></label>
                    </div>
                </div>
                <div class="switch tooltip" title=" Al activar el modo automático ten presente ajustar la humedad minima">
                    <div class="caja" >
                   <h4 style="color: black;">Automáticos</h4>
                        <input type="checkbox" class="relay_3" onchange="relay_3()" id="relay_3">
                        <label for="relay_3"></label>
                    </div>
                </div>
                <div class="switch">
                    <div class="caja">
                    <h4 style="color: black;">Relay 3</h4>
                        <input type="checkbox" class="relay_4" onchange="relay_4()" id="relay_4">
                        <label for="relay_4"></label>
                    </div>
                </div>
                <div class="switch tooltip" title="Gradúa la humedad mínima">
                    <div class="caja">
                        <h4>Humedad mínima</h4>
                        <input type="range" min="0" max="100" value="50" onchange="processSlider()" id="mySlider">
                        <p> Valor:<span id="sliderValue">50</span></p>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <script src="./index.js"></script>
    <script src="./jquery.js"></script>
    <script src="./mqtt.min.js"></script>
    
    <script type="text/javascript">

function update_values(temp,huma,hums){
    $("#display_temp").html(temp);
    $("#display_huma").html(huma);
    $("#display_hums").html(hums);
}



function process_msg(topic,message){
    //ej:"10,11,12"
    if(topic=="values"){
        var msg = message.toString();
        var sp = msg.split(",")
        var temp = sp[0];
        var hums = sp[1];
        var huma = sp[2];
        update_values(temp,hums,huma)
    }
    
    if(topic=="alerta"){
      
       alert(message);
    }
   
}
function processSlider(){
    const $slider= $("#mySlider");
    const $sliderValue = $("#sliderValue");

    $sliderValue.html($slider.val());
    var msg=$slider.val();
    client.publish('humedadMinima',msg,(error)=>{
            console.log(error||"Humedad minima enviado");
            console.log(msg);
        });
}
function relay_1(){
    if($('#relay_1').is(":checked")){
        console.log("Encendido");
        client.publish('relay_1','on',(error) => {
            console.log(error || 'Mensaje enviado led 1!!!')
        })
    } 
    else{
        console.log("Apagado");
        client.publish('relay_1','off', (error)=>{
            console.log(error || 'Mensaje enviado led 1!!!')
        
    })
    }
} 
function relay_2(){
    if($('#relay_2').is(":checked")){
        console.log("Encendido");
        client.publish('relay_2','on',(error) => {
            console.log(error || 'Mensaje enviado led 2!!!')
        })
    } 
    else{
        console.log("Apagado");
        client.publish('relay_2','off', (error)=>{
            console.log(error || 'Mensaje enviado led 2!!!')
        
    })
    }
} 
function relay_3(){
    if($('#relay_3').is(":checked")){
        console.log("Encendido");
        client.publish('relay_3','on',(error) => {
            console.log(error || 'Mensaje enviado led 3!!!')
        })
    } 
    else{
        console.log("Apagado");
        client.publish('relay_3','off', (error)=>{
            console.log(error || 'Mensaje enviado led 3!!!')
        
    })
    }
}

function relay_4(){
    if($('#relay_4').is(":checked")){
        console.log("Encendido");
        client.publish('relay_4','on',(error) => {
            console.log(error || 'Mensaje enviado led 4!!!')
        })
    } 
    else{
        console.log("Apagado");
        client.publish('relay_4','off', (error)=>{
            console.log(error || 'Mensaje enviado led 4!!!')
        
    })
    }
} 

function generateRandomClientId() {
  const clientIdLength = 10; // Longitud deseada del clientId
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  let clientId = 'emqx';

  for (let i = 0; i < clientIdLength; i++) {
    const randomIndex = Math.floor(Math.random() * characters.length);
    clientId += characters.charAt(randomIndex);
  }

  return clientId;
}


 const options={
    connectTimeout: 2000,
    clientId:generateRandomClientId(),
    username: 'web_client',
    password: '121212',
    keepalive: 60,
    clean: true,
 };

 var connected = false;
 const WebSocked_URL = 'wss://ngiot2023.online:8094/mqtt';
 const client = mqtt.connect(WebSocked_URL, options);
 client.on ('connect',() => {
    console.log('Mqtt conectado ¡Exito!')
    client.subscribe('values',{
        qos : 0
    }, (error) =>{
        if(!error){
             console.log('Suscripcion exitosa')
        }
        else{
                console.log ('Suscripcion fallida')
            }
    
    })
    
    client.subscribe('alerta',{
        qos : 2
    }, (error) =>{
        if(!error){
             console.log('Suscripcion exitosa')
        }
        else{
                console.log ('Suscripcion fallida')
            }
    
            })

    })

    client.publish('fabrica', 'esto es un verdadero exito',(error) => {
        console.log(error || 'mensaje enviado!!!')
    })
    
    client.on('message', (topic,message)=> {
           console.log('mensaje recibido bajo topico: ',topic, '->', message.toString())
        process_msg(topic,message);
    })

    client.on('reconnect',(error) => {
        console.log('error al reconectar', error)
    })

    client.on('error', (error) => {
        console.log('error de conexión:', error);
    })          

    </script>
</body>

</html>
