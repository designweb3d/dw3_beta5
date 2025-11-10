import * as THREE from 'three';
import { GLTFLoader } from '/api/three.js/examples/jsm/loaders/GLTFLoader.js';
import { OBJLoader } from '/api/three.js/examples/jsm/loaders/OBJLoader.js';
import { MTLLoader } from '/api/three.js/examples/jsm/loaders/MTLLoader.js';
var scripts = document.getElementsByTagName('script');
var lastScript = scripts[scripts.length-1];
var scriptName = lastScript;
var image_src = scriptName.getAttribute('data-bg3');
var objects = [];
var objects_id = [];
var objects_name = [];

//document.getElementById('dw3_body').style.cursor = "pointer";
//document.getElementById('dw3_scene').style.position = "fixed";
//document.getElementById('dw3_scene').style.zIndex = "4000";
document.getElementById('dw3_scene').style.background = "transparent";

const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
const renderer = new THREE.WebGLRenderer({
  canvas: document.querySelector('#dw3_scene'),antialias: true, alpha: true
});


renderer.setClearColor(0x000000, 0); 
renderer.setPixelRatio(window.devicePixelRatio);
renderer.setSize(window.innerWidth, window.innerHeight);
camera.position.setX(90);
camera.position.setY(10);
camera.position.setZ(250);
camera.rotation.set(0.25,0,0); 

window.addEventListener("resize", onWindowResize, false);
function onWindowResize() {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
}

function moveCamera() {
    const t = document.body.getBoundingClientRect().top;
    camera.position.setZ(350+Math.floor(t/2));
    //console.log(350+Math.floor(t/2));
}
  

  //bee light
let light1 = new THREE.PointLight('grey', 8, 200, 0.5);
light1.position.set(55, 90, -250);
light1.castShadow = true;
scene.add(light1);

const ambientLight3 = new THREE.AmbientLight(0xffffff,1); 
scene.add(ambientLight3);

//bee
let bee,ailes;
let loader = new GLTFLoader(); 
loader.load('/pub/scene/The_Bee/bee.gltf', function(gltf){
    gltf.scene.scale.set(0.2,0.2,0.2);
    gltf.scene.position.x = 75; 
    gltf.scene.position.y = 25;
    gltf.scene.position.z = -275;
    gltf.scene.rotation.x = 0.3;
    gltf.scene.rotation.y = 0.2;
    gltf.scene.rotation.z = 0.5;
    scene.add(gltf.scene);
    bee = gltf.scene;
});
let loader2 = new GLTFLoader(); 
loader2.load('/pub/scene/The_Bee/ailes.gltf', (gltf)=>{
    gltf.scene.scale.set(0.2,0.2,0.2);
    gltf.scene.position.x = 75; 
    gltf.scene.position.y = 25;
    gltf.scene.position.z = -275;
    gltf.scene.rotation.x = 0.3;
    gltf.scene.rotation.y = 0.2;
    gltf.scene.rotation.z = 0.5;
    ailes = gltf.scene;
    scene.add(gltf.scene);
});

// Background
function setBackground(scene, backgroundImageWidth, backgroundImageHeight) {
	var windowSize = function(withScrollBar) {
		var wid = 0;
		var hei = 0;
		if (typeof window.innerWidth != "undefined") {
			wid = window.innerWidth;
			hei = window.innerHeight;
		}
		else {
			if (document.documentElement.clientWidth == 0) {
				wid = document.body.clientWidth;
				hei = document.body.clientHeight;
			}
			else {
				wid = document.documentElement.clientWidth;
				hei = document.documentElement.clientHeight;
			}
		}
		return { width: wid - (withScrollBar ? (wid - document.body.offsetWidth + 1) : 0), height: hei };
	};

	if (scene.background) {

		var size = windowSize(true);
		var factor = (backgroundImageWidth / backgroundImageHeight) / (size.width / size.height);

		scene.background.offset.x = factor > 1 ? (1 - 1 / factor) / 2 : 0;
		scene.background.offset.y = factor > 1 ? 0 : (1 - factor) / 2;

		scene.background.repeat.x = factor > 1 ? 1 / factor : 1;
		scene.background.repeat.y = factor > 1 ? 1 : factor;
	}
}
//const spaceTexture = new THREE.TextureLoader().load(image_src);
//scene.background = spaceTexture;
//setBackground(scene, 2000, 1333);


document.body.onscroll = moveCamera;
moveCamera();

// Animation Loop
let ailes_anim_size = 0.1;       
let ailes_anim_reverse = false; 

function animate(currentTime) {
  requestAnimationFrame(animate);

//ailes
    if (ailes_anim_reverse == true){
        ailes_anim_size = ailes_anim_size - 0.02;
    } else {
        ailes_anim_size = ailes_anim_size + 0.02;
    }
    if (ailes){
        ailes.scale.set(ailes_anim_size,0.2,ailes_anim_size);
    }
    if (ailes_anim_size < 0.1){
        ailes_anim_size = 0.3;
        ailes_anim_reverse = true;
    }
    if (ailes_anim_size > 0.3){
        ailes_anim_size = 0.1;
        ailes_anim_reverse = false;
    }
  renderer.render(scene, camera);
}
animate();