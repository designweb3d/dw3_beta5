import * as THREE from 'three';
//import \* as THREE from '/api/three.js/build/three.module.js';
//import { OrbitControls } from '/api/three.js/examples/jsm/controls/OrbitControls.js';
import { GLTFLoader } from '/api/three.js/examples/jsm/loaders/GLTFLoader.js';

function iOS() {
  return [
  'iPad Simulator',
  'iPhone Simulator',
  'iPod Simulator',
  'iPad',
  'iPhone',
  'iPod'
  ].includes(navigator.platform)
  // iPad on iOS 13 detection
  || (navigator.userAgent.includes("Mac") && "ontouchend" in document)
}

// Setup

const scene = new THREE.Scene();

const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 2000);

const renderer = new THREE.WebGLRenderer({
  canvas: document.querySelector('#dw3_scene'),antialias: true, alpha: true
});

renderer.setPixelRatio(window.devicePixelRatio);
renderer.setSize(window.outerWidth, window.outerHeight);
camera.position.setX(100);
camera.position.setY(0);
camera.position.setZ(1250);
camera.rotation.set(0,0,0); 

renderer.render(scene, camera);
function moveCamera() {
    const t = document.body.getBoundingClientRect().top;
    //moon.rotation.x += 0.05;
    //moon.rotation.y += 0.075;
    //moon.rotation.z += 0.05;
  
    //jeff.rotation.y += 0.01;
    //jeff.rotation.z += 0.01;
  
    //loader2.scene.rotation.z += 0.02;
    //scene.loader2.position.z += 0.01;
    if (lotus1){
      //lotus1.rotation.y += 0.02;
    }
    pointLight.position.set(100, t+350, -10);
    camera.position.setZ(1250+Math.floor(t/2));
    //pointLight2.position.set(0, ((750)+t)*0.5, 60);
    //pointLight3.position.set(-300, ((800)+t)*1, 66);
    //pointLight4.position.set(300, ((930)+t)*1.5, 75);
    //pointLight5.position.set(200, ((1000)+t)*1.1, 80);
    //pointLight6.position.set(-200, ((1700)+t)*1.6, 100);
    //pointLight7.position.set(100, ((500)+t)*0.75, 70);
  
    //camera.position.z = t * -0.01;
    //camera.position.x = t * -0.0002;
    //camera.rotation.y = t * -0.0002;
    
  //if (checkVisible(getElementById))
  
  }
  
// Lights

const pointLight = new THREE.PointLight(0xffffff);
pointLight.position.set(100, 135, 60);
const ambientLight = new THREE.AmbientLight(0xffffff);
scene.add(pointLight, ambientLight);

const pointLight2 = new THREE.PointLight(0xffffff);
pointLight2.position.set(-300, Math.floor(Math.random() * 2000)-1000, 360);
const ambientLight2 = new THREE.AmbientLight(0xffffff);
scene.add(pointLight2, ambientLight2);

const pointLight3 = new THREE.PointLight(0xffffff);
pointLight3.position.set(0, Math.floor(Math.random() * 2000)-1000, 470);
const ambientLight3 = new THREE.AmbientLight(0xffffff);
scene.add(pointLight3, ambientLight3);

const pointLight4 = new THREE.PointLight(0xffffff);
pointLight4.position.set(50, Math.floor(Math.random() * 2000)-1000, 290);
const ambientLight4 = new THREE.AmbientLight(0xffffff);
scene.add(pointLight4, ambientLight4);

const pointLight5 = new THREE.PointLight(0xffffff);
pointLight4.position.set(400, Math.floor(Math.random() * 2000)-1000, 680);
const ambientLight5 = new THREE.AmbientLight(0xffffff);
scene.add(pointLight5, ambientLight5);

const pointLight6 = new THREE.PointLight(0xffffff);
pointLight6.position.set(200, Math.floor(Math.random() * 2000)-1000, 665);
const ambientLight6 = new THREE.AmbientLight(0xffffff);
scene.add(pointLight6, ambientLight6);

const pointLight7 = new THREE.PointLight(0xffffff);
pointLight7.position.set(-200, Math.floor(Math.random() * 2000)-1000, 475);
const ambientLight7 = new THREE.AmbientLight(0xffffff);
scene.add(pointLight7, ambientLight7);

// Torus

//const geometry = new THREE.TorusGeometry(10, 3, 16, 100);
//const material = new THREE.MeshStandardMaterial({ color: 0x3333ff });
//const torus = new THREE.Mesh(geometry, material);

//scene.add(torus);

// Helpers

// const lightHelper = new THREE.PointLightHelper(pointLight)
// const gridHelper = new THREE.GridHelper(200, 50);
// scene.add(lightHelper, gridHelper)

 //const controls = new OrbitControls(camera, renderer.domElement);

function addStar() {
  const geometry = new THREE.SphereGeometry(0.25, 24, 24);
  const material = new THREE.MeshStandardMaterial({ color: 0xffffff });
  const star = new THREE.Mesh(geometry, material);

  const [x, y, z] = Array(3)
    .fill()
    .map(() => THREE.MathUtils.randFloatSpread(100));

  star.position.set(x, y, z);
  scene.add(star);
}

//Array(200).fill().forEach(addStar);

// Background

//const spaceTexture = new THREE.TextureLoader().load('img/bg.png');
//scene.background = spaceTexture;

// Avatar

//const jeffTexture = new THREE.TextureLoader().load('logo.png');
//const jeff = new THREE.Mesh(new THREE.BoxGeometry(3, 3, 3), new THREE.MeshBasicMaterial({ map: jeffTexture }));
//scene.add(jeff);
let lotus1;
let loader = new GLTFLoader(); 
loader.load('/pub/scene/Reseaux_sociaux/scene.gltf', function(gltf){
    gltf.scene.scale.set(1,1,1);
    gltf.scene.position.x =  0;
    gltf.scene.position.y = 0;
    gltf.scene.position.z =  0;
    gltf.scene.rotation.x =  0;
    gltf.scene.rotation.y =  0;
    gltf.scene.rotation.z =  0;
    scene.add(gltf.scene);
    lotus1 = gltf.scene;
});

//


// Moon

//const moonTexture = new THREE.TextureLoader().load('moon.jpg');
//const normalTexture = new THREE.TextureLoader().load('normal.jpg');

//const moon = new THREE.Mesh(
  //new THREE.SphereGeometry(3, 32, 32),
  //new THREE.MeshStandardMaterial({
   // map: moonTexture,
  //  normalMap: normalTexture,
  //})
//);

//scene.add(moon);

//moon.position.z = 30;
//moon.position.setX(-10);

//jeff.position.z = -5;
//jeff.position.x = 2;

// Scroll Animation



document.body.onscroll = moveCamera;
moveCamera();
//
function checkVisible(elm) {
  var rect = elm.getBoundingClientRect();
  var viewHeight = Math.max(document.documentElement.clientHeight, window.innerHeight);
  return !(rect.bottom < 0 || rect.top - viewHeight >= 0);
}
// Animation Loop

function animate() {
  requestAnimationFrame(animate);

  //torus.rotation.x += 0.01;
  //torus.rotation.y += 0.005;
  //torus.rotation.z += 0.01;

  //moon.rotation.x += 0.005;
  if (lotus1){
    //lotus1.rotation.y += 0.001;
  }

  //pointLight.position.y -= 0.1;
  pointLight2.position.y -= 0.4;
  pointLight3.position.y -= 0.5;
  pointLight4.position.y -= 0.6;
  pointLight5.position.y -= 0.3;
  pointLight6.position.y -= 0.5;
  pointLight7.position.y -= 0.4;

  pointLight2.position.z -= 0.01;
  pointLight3.position.z -= 0.02;
  pointLight4.position.z -= 0.03;
  pointLight5.position.z -= 0.01;
  pointLight6.position.z -= 0.03;
  pointLight7.position.z -= 0.02;
   //controls.update();

  if (pointLight7.position.y < -4800){
    pointLight7.position.y=2800;
    pointLight7.position.z=Math.floor(Math.random() * 140)+200;
}
  if (pointLight6.position.y < -4800){
    pointLight6.position.y=2800;
    pointLight6.position.z=Math.floor(Math.random() * 140)+200;
}
  if (pointLight5.position.y < -4800){
    pointLight5.position.y=2800;
    pointLight5.position.z=Math.floor(Math.random() * 140)+200;
}
  if (pointLight4.position.y < -4800){
    pointLight4.position.y=2800;
    pointLight4.position.z=Math.floor(Math.random() * 140)+200;
}
  if (pointLight3.position.y < -4800){
    pointLight3.position.y=2800;
    pointLight3.position.z=Math.floor(Math.random() * 340)+200;
}
  if (pointLight2.position.y < -4800){
    pointLight2.position.y=2800;
    pointLight2.position.z=Math.floor(Math.random() * 340)+200;
}

  renderer.render(scene, camera);
}

animate();