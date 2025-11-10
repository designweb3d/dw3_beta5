import * as THREE from 'three';
/* import { OrbitControls } from '/api/three.js/examples/jsm/controls/OrbitControls.js';
import { GLTFLoader } from '/api/three.js/examples/jsm/loaders/GLTFLoader.js'; */

var scripts = document.getElementsByTagName('script');
var lastScript = scripts[scripts.length-1];
var scriptName = lastScript;
var image_src = scriptName.getAttribute('data-bg3');

let stars,backgroundMesh;
  const starCount = 1500;
  const starGeometry = new THREE.BufferGeometry();
  const starPositions = [];
  const colors = [];
  const color = new THREE.Color();

// Setup

const scene = new THREE.Scene();

const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);

const renderer = new THREE.WebGLRenderer({
  canvas: document.querySelector('#dw3_scene'),antialias: true, alpha: true
});

renderer.setPixelRatio(window.devicePixelRatio);
renderer.setSize(window.innerWidth, window.innerHeight);
camera.position.setZ(30);
camera.position.setX(-5);

renderer.render(scene, camera);

const imgBG = new Image();
let imgBG_width = 0;
let imgBG_height = 0;
imgBG.onload = function() {
  imgBG_width = this.width;
  imgBG_height = this.height;
  //background
    // 1. Load the texture
    const textureLoader = new THREE.TextureLoader();
    const backgroundTexture = textureLoader.load(image_src);

    //console.log("Background image source:", image_src);

    // 2. Create a plane geometry that fills the camera's view
    // Adjust these values based on your camera's field of view and distance
    const planeGeometry = new THREE.PlaneGeometry(100, 100); // Large enough to cover the screen

    // 3. Create a material with the texture
    const backgroundMaterial = new THREE.MeshBasicMaterial({
        map: backgroundTexture,
        side: THREE.FrontSide, // Or THREE.DoubleSide if needed
        transparent: true
    });

    // 4. Create a mesh and position it behind your main scene
    backgroundMesh = new THREE.Mesh(planeGeometry, backgroundMaterial);
    backgroundMesh.position.z = -100; // Adjust Z position to be behind other objects

    // 5. Add the background mesh to the scene
    scene.add(backgroundMesh);
    // Call this function initially and on window resize
    adjustBackgroundScale();
    window.addEventListener('resize', onWindowResize);
}
imgBG.src = image_src;



// 6. Adjust the background mesh's scale to "cover" the screen
// This requires calculating the aspect ratio of the image and the screen
// and scaling the plane accordingly.
function adjustBackgroundScale() {
    const windowAspect = window.innerWidth / window.innerHeight;
    const imageAspect1 = imgBG_width / imgBG_height;
    const imageAspect2 = imgBG_height / imgBG_width;


    if (window.innerWidth > imgBG_width) {
        // Window is wider than image, scale plane height to match window height
        backgroundMesh.scale.set(imageAspect2, imageAspect1, 1);
        //console.log("Adjusting background scale: wider window");
    } else {
        // Window is taller than image, scale plane width to match window width
        //backgroundMesh.scale.set(1, imageAspect, 1);
        //backgroundMesh.scale.set(imageAspect1*2, imageAspect2*2, 1);
        //console.log("Adjusting background scale: taller window");
    }
}

    function onWindowResize() {
      camera.aspect = window.innerWidth / window.innerHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(window.innerWidth, window.innerHeight);
      adjustBackgroundScale();
    }

// Torus

//const geometry = new THREE.TorusGeometry(10, 3, 16, 100);
//const material = new THREE.MeshStandardMaterial({ color: 0x3333ff });
//const torus = new THREE.Mesh(geometry, material);

//scene.add(torus);

// Lights

const pointLight = new THREE.PointLight(0xffffff);
pointLight.position.set(5, 5, 5);

const ambientLight = new THREE.AmbientLight(0xffffff);
scene.add(pointLight, ambientLight);

// Helpers

// const lightHelper = new THREE.PointLightHelper(pointLight)
// const gridHelper = new THREE.GridHelper(200, 50);
// scene.add(lightHelper, gridHelper)

// const controls = new OrbitControls(camera, renderer.domElement);

      // Generate starfield
      for (let i = 0; i < starCount; i++) {
        const x = THREE.MathUtils.randFloatSpread(100); // Spread stars in wide area
        const y = THREE.MathUtils.randFloatSpread(100);
        const z = THREE.MathUtils.randFloat(-22, -500);
        starPositions.push(x, y, z);
        color.setRGB(Math.random()*10, Math.random()*10, Math.random()*10);
        colors.push(color.r, color.g, color.b);
      }
      starGeometry.setAttribute('position', new THREE.Float32BufferAttribute(starPositions, 3));
    starGeometry.setAttribute('color', new THREE.Float32BufferAttribute(colors, 3));

      const starMaterial = new THREE.PointsMaterial({ color: 0xffffff, size: 0.3, vertexColors: true  ,sizeAttenuation: true });
      stars = new THREE.Points(starGeometry, starMaterial);
      scene.add(stars);

// Background

//const spaceTexture = new THREE.TextureLoader().load('img/bg.png');
//scene.background = spaceTexture;

// Avatar

//const jeffTexture = new THREE.TextureLoader().load('logo.png');
//const jeff = new THREE.Mesh(new THREE.BoxGeometry(3, 3, 3), new THREE.MeshBasicMaterial({ map: jeffTexture }));
//scene.add(jeff);
/* let lotus1, lotus2, lotus3, lotus4;
let loader = new GLTFLoader(); 
loader.load('/pub/scene/Lotus/scene.gltf', function(gltf){
    gltf.scene.scale.set(1,1,1);
    gltf.scene.position.x =  25;
    gltf.scene.position.y = -10;
    gltf.scene.position.z =  -25;
    gltf.scene.rotation.x =  45;
    gltf.scene.rotation.y =  0;
    gltf.scene.rotation.z =  0;
    scene.add(gltf.scene);
    lotus1 = gltf.scene;
});
let loader2 = new GLTFLoader(); 
loader2.load('/pub/scene/Lotus/scene.gltf', (gltf)=>{
    gltf.scene.scale.set(1,1,1);
    gltf.scene.position.x = 0;
    gltf.scene.position.y =  0;
    gltf.scene.position.z =  -20;
    gltf.scene.rotation.x =  45;
    gltf.scene.rotation.y =  145;
    gltf.scene.rotation.z =  0;
    lotus2 = gltf.scene;
    scene.add(gltf.scene);
});
let loader3 = new GLTFLoader(); 
loader3.load('/pub/scene/Lotus/scene.gltf', (gltf)=>{
    gltf.scene.scale.set(1,1,1);
    gltf.scene.position.x = -10;
    gltf.scene.position.y =  0;
    gltf.scene.position.z =  20;
    gltf.scene.rotation.x =  45;
    gltf.scene.rotation.y =  0;
    gltf.scene.rotation.z =  0;
    lotus3 = gltf.scene;
    scene.add(gltf.scene);
});
let loader4 = new GLTFLoader(); 
loader4.load('/pub/scene/Lotus/scene.gltf', (gltf)=>{
    gltf.scene.scale.set(0.7,0.7,0.7);
    gltf.scene.position.x = -10;
    gltf.scene.position.y =  0;
    gltf.scene.position.z =  55;
    gltf.scene.rotation.x =  44.5;
    gltf.scene.rotation.y =  0;
    gltf.scene.rotation.z =  0;
    lotus4 = gltf.scene;
    scene.add(gltf.scene);
}); */

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

function moveCamera() {
  const t = document.body.getBoundingClientRect().top;
  //moon.rotation.x += 0.05;
  //moon.rotation.y += 0.075;
  //moon.rotation.z += 0.05;

  //jeff.rotation.y += 0.01;
  //jeff.rotation.z += 0.01;

  //loader2.scene.rotation.z += 0.02;
  //scene.loader2.position.z += 0.01;
 /*  if (lotus1){
    lotus1.rotation.y += 0.02;
  }
  if (lotus2){
    lotus2.rotation.y += 0.02;
  }
  if (lotus3){
    lotus3.rotation.y += 0.02;
  }
  if (lotus4){
    lotus3.rotation.y += 0.01;
  } */

  camera.position.z = t * +0.03;
  camera.position.x = t * +0.0002;
  //camera.rotation.y = t * +0.0002;
  
//if (checkVisible(getElementById))

}

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

        // Move stars
        const positions = stars.geometry.attributes.position.array;
        for (let i = 2; i < positions.length; i += 3) {
          positions[i] += 1; // z component - move toward camera

          if (positions[i] > -25) {
            positions[i] = -500; // Reset to far back
            positions[i - 1] = THREE.MathUtils.randFloatSpread(100); // y
            positions[i - 2] = THREE.MathUtils.randFloatSpread(100); // x
          }
        }
        stars.geometry.attributes.position.needsUpdate = true;

  // controls.update();
camera.rotation.z -= 0.01;
  renderer.render(scene, camera);
}

animate();

/* function setBackground(scene, backgroundImageWidth, backgroundImageHeight) {
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
} */
