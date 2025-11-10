import * as THREE from 'three';
//import { OrbitControls } from '/api/three.js/examples/jsm/controls/OrbitControls.js';
import { GLTFLoader } from '/api/three.js/examples/jsm/loaders/GLTFLoader.js';

const scene = new THREE.Scene();

const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);

const renderer = new THREE.WebGLRenderer({
  canvas: document.querySelector('#dw3_scene'),antialias: true, alpha: true
});

renderer.setPixelRatio(window.devicePixelRatio);
renderer.setSize(window.innerWidth, window.innerHeight);
camera.position.setZ(13);
camera.position.setX(-9);
camera.position.setY(-5);
camera.rotation.set(0.85,0,0);

renderer.render(scene, camera);

const pointLight = new THREE.PointLight(0xffffff);
pointLight.position.set(-10, -35, 20);

const ambientLight = new THREE.AmbientLight(0xffffff);
scene.add(pointLight, ambientLight);

const pointLight2 = new THREE.PointLight(0xffffff);
pointLight2.position.set(0, 0, 20);

const ambientLight2 = new THREE.AmbientLight(0xffffff);
scene.add(pointLight2, ambientLight2);

let loader = new GLTFLoader(); 

let carColorBL = new THREE.Color(0x000000);
let carColorGR = new THREE.Color(0x666666);
var race_stat= true;

var score = document.createElement("div");
score.setAttribute("id", "div_score");
score.style.background = "#EEE";
score.style.borderRadius = "5px";
score.style.border = "1px dotted darkgreen";
score.style.transition ="all 1s";
score.style.fontWeight ="bold";
score.style.fontSize ="1.6rem";
score.style.textAlign ="left";
score.style.width ="400px";
score.style.maxWidth ="400px";
score.style.textShadow ="2px 2px #DDDDDD";
score.style.padding ="0px 5px 5px 5px";
score.style.margin ="5px";
score.style.cursor ="pointer";
score.style.display ="table";
score.style.opacity ="0.8";

var score_menu = document.createElement("div");
score_menu.style.textAlign ="center";
var score_reset = document.createElement("button");
score_reset.innerHTML=" Reset ";
score_reset.onclick = function () {
    resetAnim();
};
var score_anim = document.createElement("button");
score_anim.setAttribute("id","score_btn");
score_anim.style.fontWeight ="bold";
score_anim.innerHTML="| |";
score_anim.onclick = function () {
    toggleAnim();
};
var score_board = document.createElement("div");
score_board.innerHTML = "<div style='width:240px;text-align:center;'></div><hr><span style='color:green;'>Voiture #1</span> Laps: <span id='score_car1lap'>1</span><span id='score1_rank' style='margin-right:5px;float:right;'></span><br><span style='color:red;'>Voiture #2</span> Laps: <span id='score_car2lap'>1</span><span id='score2_rank' style='margin-right:5px;float:right;'></span><br><span style='color:blue;'>Voiture #3</span> Laps: <span id='score_car3lap'>1</span><span id='score3_rank' style='margin-right:5px;float:right;'></span><br><span style='color:#FFFF33;'>Voiture #4</span> Laps: <span id='score_car4lap'>1</span><span id='score4_rank' style='margin-right:5px;float:right;'></span><br><span style='color:#222;'>Voiture #5</span> Laps: <span id='score_car5lap'>1</span><span id='score5_rank' style='margin-right:5px;float:right;'></span>";

score_menu.append(score_reset);
score_menu.append(score_anim);
score.append(score_menu);
score.append(score_board);

var footer_before = document.querySelector('.dw3_page_foot')
footer_before.parentNode.insertBefore(score, footer_before);


let car1km = 0;
let car1lap = 1;
let car1max = (rand(5)+15)/100;
let car1ms = (rand(5)+1)/50;
let car1acc = (rand(5))/2000;
let car1Color = new THREE.Color(0x00ff00);
let lotus1;
loader.load('/pub/scene/Shelby/scene2.gltf', function(gltf){
    gltf.scene.scale.set(0.5,0.5,0.5);
    gltf.scene.position.x =  -3;
    gltf.scene.position.y = 20;
    gltf.scene.position.z =  10;
    gltf.scene.rotation.x =  1.5;
    gltf.scene.rotation.y =  1.46;
    gltf.scene.rotation.z =  0;
    //gltf.children[0].children[0].material.color = carColorBL;
    scene.add(gltf.scene);
    lotus1 = gltf.scene;
    let material = scene.children[4].children[0].children[0].material;
    material.color = carColorBL;
    let material1 = scene.children[4].children[0].children[1].material;
    material1.color = carColorBL;
    let material2 = scene.children[4].children[35].children[0].material;
    material2.color = car1Color;
    let material3 = scene.children[4].children[35].children[1].material;
    material3.color = car1Color;

    //let material4 = scene.children[4].children[4].children[0].material; MIRROIRS
    //let material4 = scene.children[4].children[6].children[0].material; //MIRROIRS et 1/2 et caps de roues??
    //let material4 = scene.children[4].children[44].children[0].material; //2iem coté bord vitre
    //let material4 = scene.children[4].children[24].children[3].material;  vitre aussi?
    //let material4 = scene.children[4].children[5].material; MIRROIRS et 1/2
    //let material4 = scene.children[4].children[9].material; MIRROIRS et 1/2 et caps de roues??
    //let material4 = scene.children[4].children[12].material; vitre
    //let material4 = scene.children[4].children[29].material; banc 1/2
    //let material4 = scene.children[4].children[36].material; banc
    //let material4 = scene.children[4].children[31].material; banc

    let material4 = scene.children[4].children[12].material;  
    material4.color = carColorGR;
    let material5 = scene.children[4].children[5].material;  
    material5.color = carColorBL;
    let material6 = scene.children[4].children[31].material;  
    material6.color = carColorBL;
    let material7 = scene.children[4].children[44].children[0].material;  
    material7.color = carColorBL;

});

let car2km = 0;
let car2lap = 1;
let car2max = (rand(5)+15)/100;
let car2ms = (rand(5)+1)/50;
let car2acc = (rand(5))/1000;
let car2Color = new THREE.Color(0xff0000);
let lotus2;
loader.load('/pub/scene/Shelby/scene2.gltf', function(gltf){
    gltf.scene.scale.set(0.5,0.5,0.5);
    gltf.scene.position.x =  -5;
    gltf.scene.position.y =20;
    gltf.scene.position.z =  10;
    gltf.scene.rotation.x =  1.5;
    gltf.scene.rotation.y =  1.46;
    gltf.scene.rotation.z =  0;
    scene.add(gltf.scene);
    lotus2 = gltf.scene;
    let material = scene.children[5].children[0].children[0].material;
    material.color = carColorBL;
    let material1 = scene.children[5].children[0].children[1].material;
    material1.color = carColorBL;
    let material2 = scene.children[5].children[35].children[0].material;
    material2.color = car2Color;
    let material3 = scene.children[5].children[35].children[1].material;
    material3.color = car2Color;
    let material4 = scene.children[5].children[12].material;  
    material4.color = carColorGR;
    let material5 = scene.children[5].children[5].material;  
    material5.color = carColorBL;
    let material6 = scene.children[5].children[31].material;  
    material6.color = carColorBL;
    let material7 = scene.children[5].children[44].children[0].material;  
    material7.color = carColorBL;
});
let car3km = 0;
let car3lap = 1;
let car3max = (rand(5)+15)/100;
let car3ms = (rand(5)+1)/50;
let car3acc = (rand(5))/1000;
let car3Color = new THREE.Color(0x0000ff);
let lotus3;
loader.load('/pub/scene/Shelby/scene2.gltf', function(gltf){
    gltf.scene.scale.set(0.5,0.5,0.5);
    gltf.scene.position.x =  -7;
    gltf.scene.position.y = 20;
    gltf.scene.position.z =  10;
    gltf.scene.rotation.x =  1.5;
    gltf.scene.rotation.y =  1.46;
    gltf.scene.rotation.z =  0;
    scene.add(gltf.scene);
    lotus3 = gltf.scene;
    let material = scene.children[6].children[0].children[0].material;
    material.color = carColorBL;
    let material1 = scene.children[6].children[0].children[1].material;
    material1.color = carColorBL;
    let material2 = scene.children[6].children[35].children[0].material;
    material2.color = car3Color;
    let material3 = scene.children[6].children[35].children[1].material;
    material3.color = car3Color;
    let material4 = scene.children[6].children[12].material;  
    material4.color = carColorGR;
    let material5 = scene.children[6].children[5].material;  
    material5.color = carColorBL;
    let material6 = scene.children[6].children[31].material;  
    material6.color = carColorBL;
    let material7 = scene.children[6].children[44].children[0].material;  
    material7.color = carColorBL;
});

let car4km = 0;
let car4lap = 1;
let car4max = (rand(5)+15)/100;
let car4ms = (rand(5)+1)/50;
let car4acc = (rand(5))/1000;
let car4Color = new THREE.Color(0xffff33);
let lotus4;
loader.load('/pub/scene/Shelby/scene2.gltf', function(gltf){
    gltf.scene.scale.set(0.5,0.5,0.5);
    gltf.scene.position.x =  -1;
    gltf.scene.position.y = 20;
    gltf.scene.position.z =  10;
    gltf.scene.rotation.x =  1.5;
    gltf.scene.rotation.y =  1.46;
    gltf.scene.rotation.z =  0;
    scene.add(gltf.scene);
    lotus4 = gltf.scene;
    let material = scene.children[7].children[0].children[0].material;
    material.color = carColorBL;
    let material1 = scene.children[7].children[0].children[1].material;
    material1.color = carColorBL;
    let material2 = scene.children[7].children[35].children[0].material;
    material2.color = car4Color;
    let material3 = scene.children[7].children[35].children[1].material;
    material3.color = car4Color;
    let material4 = scene.children[7].children[12].material;  
    material4.color = carColorGR;
    let material5 = scene.children[7].children[5].material;  
    material5.color = carColorBL;
    let material6 = scene.children[7].children[31].material;  
    material6.color = carColorBL;
    let material7 = scene.children[7].children[44].children[0].material;  
    material7.color = carColorBL;
});

let car5km = 0;
let car5lap = 1;
let car5max = (rand(5)+15)/100;
let car5ms = (rand(5)+1)/50;
let car5acc = (rand(5))/1000;
let car5Color = new THREE.Color(0x333333);
let lotus5;
loader.load('/pub/scene/Shelby/scene2.gltf', function(gltf){
    gltf.scene.scale.set(0.5,0.5,0.5);
    gltf.scene.position.x =  1;
    gltf.scene.position.y = 20;
    gltf.scene.position.z =  10;
    gltf.scene.rotation.x =  1.5;
    gltf.scene.rotation.y =  1.47;
    gltf.scene.rotation.z =  0;
    scene.add(gltf.scene);
    lotus5 = gltf.scene;
    let material = scene.children[8].children[0].children[0].material;
    material.color = carColorBL;
    let material1 = scene.children[8].children[0].children[1].material;
    material1.color = carColorBL;
    let material2 = scene.children[8].children[35].children[0].material;
    material2.color = car5Color;
    let material3 = scene.children[8].children[35].children[1].material;
    material3.color = car5Color;
    let material4 = scene.children[8].children[12].material;  
    material4.color = carColorGR;
    let material5 = scene.children[8].children[5].material;  
    material5.color = carColorBL;
    let material6 = scene.children[8].children[31].material;  
    material6.color = carColorBL;
    let material7 = scene.children[8].children[44].children[0].material;  
    material7.color = carColorBL;
});


//MAIN
//document.body.onscroll = calcWinner();
document.getElementById("score_car1lap").innerHTML =car1lap + " <sup>(" + Math.floor((Number(car1ms)+Number(car1acc))/2*1000) +  "mph)</sup>";
document.getElementById("score_car2lap").innerHTML =car2lap + " <sup>(" + Math.floor((Number(car2ms)+Number(car2acc))/2*1000) +  "mph)</sup>";
document.getElementById("score_car3lap").innerHTML =car3lap + " <sup>(" + Math.floor((Number(car3ms)+Number(car3acc))/2*1000) +  "mph)</sup>";
document.getElementById("score_car4lap").innerHTML =car4lap + " <sup>(" + Math.floor((Number(car4ms)+Number(car4acc))/2*1000) +  "mph)</sup>";
document.getElementById("score_car5lap").innerHTML =car5lap + " <sup>(" + Math.floor((Number(car5ms)+Number(car5acc))/2*1000) +  "mph)</sup>";

animate();


//FUNCTIONS
function rand(max) {
    return Math.floor(Math.random() * max);
  }


function resetAnim() {
    race_stat=false;
    camera.position.setZ(14);
    camera.position.setX(-5);
    camera.position.setY(-5);
    camera.rotation.set(0.9,0,0);
    car1lap = 1;
    car2lap = 1;
    car3lap = 1;
    car4lap = 1;
    car5lap = 1;
    car1ms = (rand(5)+1)/50;
    car2ms = (rand(5)+1)/50;
    car3ms = (rand(5)+1)/50;
    car4ms = (rand(5)+1)/50;
    car5ms = (rand(5)+1)/50;
    document.getElementById("score_car1lap").innerHTML =car1lap;
    document.getElementById("score_car2lap").innerHTML =car2lap;
    document.getElementById("score_car3lap").innerHTML =car3lap;
    document.getElementById("score_car4lap").innerHTML =car4lap;
    document.getElementById("score_car5lap").innerHTML =car5lap;
    lotus1.position.x =  -3;
    lotus1.position.y = 20;
    lotus1.position.z =  10;
    lotus2.position.x =  -5;
    lotus2.position.y =20;
    lotus2.position.z =  10;
    lotus3.position.x =  -7;
    lotus3.position.y = 20;
    lotus3.position.z =  10;
    lotus4.position.x =  -1;
    lotus4.position.y = 20;
    lotus4.position.z =  10;
    lotus5.position.x =  1;
    lotus5.position.y = 20;
    lotus5.position.z =  10;
    race_stat=true;
    score_anim.innerHTML = " | | ";
    animate();
  }
  function toggleAnim() {
    if (race_stat==true){
        race_stat=false;
        score_anim.innerHTML = " > ";
    } else{ 
        race_stat=true;
        score_anim.innerHTML = " | | ";
/*         camera.position.setZ(19);
        camera.position.setX(-5);
        camera.position.setY(-5);
        camera.rotation.set(0.2,0,0); */
        animate();
    }
  }
  function stopAnim() {
    //const t = document.body.getBoundingClientRect().top;
    //cancelAnimationFrame( animate_id );
    race_stat=false;
    //addMSG("La voiture #" + winner + " a gagné!");
  }


function checkWinner() {
    if (lotus1&&lotus2&&lotus3&&lotus4&&lotus5){
        const p1 = car1km;
        const p2 = car2km;
        const p3 = car3km;
        const p4 = car4km;
        const p5 = car5km;
        const array1 = [p1,p2,p3,p4,p5];
        array1.sort();
        array1.reverse();
        var arrayLength = array1.length;
        for (var i = 0; i < arrayLength; i++) {
            if(p1 == array1[i]){document.querySelector('#score1_rank').innerHTML = "<b>"+(i+1)+"</b>";}
            if(p2 == array1[i]){document.querySelector('#score2_rank').innerHTML = "<b>"+(i+1)+"</b>";}
            if(p3 == array1[i]){document.querySelector('#score3_rank').innerHTML = "<b>"+(i+1)+"</b>";}
            if(p4 == array1[i]){document.querySelector('#score4_rank').innerHTML = "<b>"+(i+1)+"</b>";}
            if(p5 == array1[i]){document.querySelector('#score5_rank').innerHTML = "<b>"+(i+1)+"</b>";}   
        }
    }
}
function checkVisible(elm) {
  var rect = elm.getBoundingClientRect();
  var viewHeight = Math.max(document.documentElement.clientHeight, window.innerHeight);
  return !(rect.bottom < 0 || rect.top - viewHeight >= 0);
}
// Animation Loop
var animate_id;
function animate() {
    if (race_stat==true){
        animate_id = requestAnimationFrame(animate);
    } else {
        return;
    }
    
  if (lotus1){
    lotus1.position.y -= car1ms;
    car1km += Math.abs(car1ms);
    if (car1ms < car1max){
        car1ms = Number(car1ms)+Number(car1acc);
        if (car1lap <= 2){car1acc =(rand(5))/3000;checkWinner();}
    }else{
        car1ms -= car1acc;
    }
    lotus1.position.x -= 0.03;
    //if (car1lap <= 2){lotus1.rotation.y -= 0.002;}
    //scene.children[4].children[7].rotation.x += 0.03;
    document.getElementById("score_car1lap").innerHTML =car1lap + " <sup>(" + Math.floor((Number(car1ms)+Number(car1acc))/2*1000) +  "mph)</sup>";
    if (lotus1.position.y <= -60){
        lotus1.position.y =33;
        lotus1.position.x = -3;
        //lotus1.rotation.y = -0.01;
        //car1ms = (rand(5)+1)/40;
        car1acc = (rand(10))/2000;
        car1max = (rand(20)+25)/100;
        car1lap++;
        checkWinner();
        if (car1lap == 3){
            //camera.position.setZ(12);
            //camera.position.setX(-5);
            //camera.position.setY(-5);
            //camera.rotation.set(0.9,0,0);
            camera.position.setZ(14);
            camera.position.setX(7);
            camera.position.setY(-5);
            camera.rotation.set(0,1.5,1.5);
        }
        if (car1lap == 6){
            camera.position.setZ(19);
            camera.position.setX(-5);
            camera.position.setY(-5);
            camera.rotation.set(0.2,0,0);
        }
        if (car1lap == 8){
            camera.position.setZ(19);
            camera.position.setX(-9);
            camera.position.setY(-25);
            camera.rotation.set(0.85,0,0);
        }
        if (car1lap== 10){
            stopAnim();
            document.getElementById("score_car1lap").innerHTML ="Gagnant!";
            document.getElementById("score_car2lap").innerHTML ="Gagnant!";
            document.getElementById("score_car3lap").innerHTML ="Gagnant!";
            document.getElementById("score_car4lap").innerHTML ="Gagnant!";
            document.getElementById("score_car5lap").innerHTML ="Gagnant!";
            document.querySelector('#score_btn').innerHTML = " > ";
            camera.position.setZ(lotus1.position.z+3);
            camera.position.setY(lotus1.position.y);
            camera.position.setX(lotus1.position.x);
            //camera.position.setY(lotus1.position.y+3);
            //camera.rotation.set(0,0,0);
            camera.rotation.set(0.3,0,0);
            renderer.render(scene, camera);
            return;
        }
    }
/*     if (car1lap == 9){
        camera.position.setZ(lotus1.position.z+0.8);
        camera.position.setX(lotus1.position.x);
        camera.position.setY(lotus1.position.y+0.1);
        camera.rotation.set(lotus1.rotation.x-0.2,lotus1.rotation.y+3,lotus1.rotation.z);
        
    } */
  }


  if (lotus2){
    lotus2.position.y -= car2ms;
    car2km += Math.abs(car2ms);
    if (car2ms < car2max){
        car2ms = Number(car2ms)+Number(car2acc);
        if (car2lap <= 2){car2acc = (rand(5))/2000;}
    }else{
        car2ms -= car2acc;
    }
    lotus2.position.x -= 0.03;
    //if (car2lap <= 2){lotus2.rotation.y -= 0.002;}
    //scene.children[5].children[7].rotation.x += 0.03;
    document.getElementById("score_car2lap").innerHTML =car2lap+ " <sup>(" + Math.floor((Number(car2ms)+Number(car2acc))/2*1000) +  "mph)</sup>";
    if (lotus2.position.y <= -60){
        lotus2.position.y =33;
        lotus2.position.x = -1;
        //lotus2.rotation.y = -0.01;
        //car2ms = (rand(5)+1)/40;
        car2acc = (rand(5))/2000;
        car2max = (rand(5)+25)/100;
        car2lap++;
        checkWinner();
        if (car2lap== 10){
            race_stat=false;
            document.getElementById("score_car1lap").innerHTML ="Gagnant!";
            document.getElementById("score_car2lap").innerHTML ="Gagnant!";
            document.getElementById("score_car3lap").innerHTML ="Gagnant!";
            document.getElementById("score_car4lap").innerHTML ="Gagnant!";
            document.getElementById("score_car5lap").innerHTML ="Gagnant!";
            document.querySelector('#score_btn').innerHTML = " > ";
            camera.position.setZ(lotus2.position.z+3);
            camera.position.setX(lotus2.position.x);
            camera.position.setY(lotus2.position.y);
            camera.rotation.set(0.3,0,0);
            renderer.render(scene, camera);
            return;
        }
    }
  }


  if (lotus3){
    car3km += Math.abs(car3ms);
    lotus3.position.y -= car3ms;
    if (car3ms < car3max){
        car3ms += car3acc;
        if (car3lap <= 2){car3acc = (rand(5))/2000;}
    }else{
        car3ms -= car3acc;
    }
    lotus3.position.x -= 0.03;
    //if (car3lap <= 2){lotus3.rotation.y -= 0.002;}
    //scene.children[6].children[7].rotation.x += 0.03;
    document.getElementById("score_car3lap").innerHTML =car3lap+ " <sup>(" + Math.floor((Number(car3ms)+Number(car3acc))/2*1000) +  "mph)</sup>";
    if (lotus3.position.y <= -60){
        lotus3.position.y =33;
        lotus3.position.x = -5 ;
        //lotus3.rotation.y = -0.01;
        //car3ms = (rand(5)+1)/40;
        car3acc = (rand(5))/2000;
        car3max = (rand(5)+25)/100;
        car3lap++;
        checkWinner();
        //document.getElementById("score_car3lap").innerHTML =car3lap+ " <sup>(" + Math.floor((Number(car3ms)+Number(car3acc))/2*1000) +  "mph)</sup>";
        if (car3lap== 10){
            race_stat=false;
            document.getElementById("score_car1lap").innerHTML ="Gagnant!";
            document.getElementById("score_car2lap").innerHTML ="Gagnant!";
            document.getElementById("score_car3lap").innerHTML ="Gagnant!";
            document.getElementById("score_car4lap").innerHTML ="Gagnant!";
            document.getElementById("score_car5lap").innerHTML ="Gagnant!";
            document.querySelector('#score_btn').innerHTML = " > ";
            camera.position.setZ(lotus3.position.z+3);
            camera.position.setX(lotus3.position.x);
            camera.position.setY(lotus3.position.y);
            camera.rotation.set(0.3,0,0);
            renderer.render(scene, camera);
            return;
        }
    }
  }
  if (lotus4){
    car4km += Math.abs(car4ms);
    lotus4.position.y -= car4ms;
    if (car4ms < car4max){
        car4ms += car4acc;
        if (car4lap <= 2){car4acc = (rand(5))/2000;}
    }else{
        car4ms -= car4acc;
    }
    lotus4.position.x -= 0.03;
    //if (car4lap <= 2){lotus4.rotation.y -= 0.002;}
    document.getElementById("score_car4lap").innerHTML =car4lap+ " <sup>(" + Math.floor((Number(car4ms)+Number(car4acc))/2*1000) +  "mph)</sup>";
    //scene.children[6].children[7].rotation.x += 0.03;
    if (lotus4.position.y <= -60){
        lotus4.position.y =33;
        lotus4.position.x = -7 ;
        //lotus4.rotation.y = -0.01;
        //car4ms = (rand(5)+1)/40;
        car4acc = (rand(5))/2000;
        car4max = (rand(5)+25)/100;
        car4lap++;
        checkWinner();
        if (car4lap== 10){
            race_stat=false;
            document.getElementById("score_car1lap").innerHTML ="Gagnant!";
            document.getElementById("score_car2lap").innerHTML ="Gagnant!";
            document.getElementById("score_car3lap").innerHTML ="Gagnant!";
            document.getElementById("score_car4lap").innerHTML ="Gagnant!";
            document.getElementById("score_car5lap").innerHTML ="Gagnant!";
            document.querySelector('#score_btn').innerHTML = " > ";
            camera.position.setZ(lotus4.position.z+3);
            camera.position.setX(lotus4.position.x);
            camera.position.setY(lotus4.position.y);
            camera.rotation.set(0.3,0,0);
            renderer.render(scene, camera);
            return;
        }
    }
  }
  if (lotus5){
    car5km += Math.abs(car5ms);
    lotus5.position.y -= car5ms;
    if (car5ms <= car5max){
        car5ms += car5acc;
        if (car5lap <= 2){car5acc = (rand(5))/2000;}
    }else{
        car5ms -= car5acc;
    }
    lotus5.position.x -= 0.03;
    //if (car5lap <= 2){lotus5.rotation.y -= 0.002;}
    //scene.children[6].children[7].rotation.x += 0.03;
    document.getElementById("score_car5lap").innerHTML =car5lap + " <sup>(" + Math.floor((Number(car5ms)+Number(car5acc))/2*1000) +  "mph)</sup>";
    if (lotus5.position.y <= -60){
        lotus5.position.y =33;
        lotus5.position.x = 1 ;
        //lotus5.rotation.y =-0.01;
        //car5ms = (rand(5)+1)/40;
        car5acc = (rand(5))/2000;
        car5max = (rand(5)+25)/100;
        car5lap++;
        checkWinner();
        if (car5lap== 10){
            race_stat=false;
            document.getElementById("score_car1lap").innerHTML ="Gagnant!";
            document.getElementById("score_car2lap").innerHTML ="Gagnant!";
            document.getElementById("score_car3lap").innerHTML ="Gagnant!";
            document.getElementById("score_car4lap").innerHTML ="Gagnant!";
            document.getElementById("score_car5lap").innerHTML ="Gagnant!";
            document.querySelector('#score_btn').innerHTML = " > ";
            camera.position.setZ(lotus5.position.z+3);
            camera.position.setX(lotus5.position.x);
            camera.position.setY(lotus5.position.y);
            camera.rotation.set(0.3,0,0);
            renderer.render(scene, camera);
            return;
        }
    }
  }

  renderer.render(scene, camera);
}



