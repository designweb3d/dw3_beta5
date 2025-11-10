import * as THREE from 'three';

			import Stats from '/api/three.js/examples/jsm/libs/stats.module.js';
			import { GUI } from '/api/three.js/examples/jsm/libs/lil-gui.module.min.js';
			import { OrbitControls } from '/api/three.js/examples/jsm/controls/OrbitControls.js';
			import { Water } from '/api/three.js/examples/jsm/objects/Water.js';
			import { Sky } from '/api/three.js/examples/jsm/objects/Sky.js';

			let container, stats;
			let camera, scene, renderer;
			let controls, water, sun, mesh;

            const radius = 100; // Distance from the object
            let angle = 10; // Current angle in radians
            const speed = -0.003; // Rotation speed

			init();
			animate();

			function init() {

				container = document.getElementById( 'scene_container' );

				//

				renderer = new THREE.WebGLRenderer();
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth, window.innerHeight );
				renderer.toneMapping = THREE.ACESFilmicToneMapping;
				container.appendChild( renderer.domElement );

				//

				scene = new THREE.Scene();

				camera = new THREE.PerspectiveCamera( 55, window.innerWidth / window.innerHeight, 1, 20000 );
				camera.position.set( 80, 60, 100 );
                camera.lookAt(0, 4.5, 0);

				//

				sun = new THREE.Vector3();

				// Water

				const waterGeometry = new THREE.PlaneGeometry( 10000, 10000 );

				water = new Water(
					waterGeometry,
					{
						textureWidth: 512,
						textureHeight: 512,
						waterNormals: new THREE.TextureLoader().load( '/pub/scene/Ocean/waternormals.jpg', function ( texture ) {

							texture.wrapS = texture.wrapT = THREE.RepeatWrapping;

						} ),
						sunDirection: new THREE.Vector3(),
						sunColor: 0xffffff,
						waterColor: 0x001e0f,
						distortionScale: 3.7,
						fog: scene.fog !== undefined
					}
				);

				water.rotation.x = - Math.PI / 2;

				scene.add( water );

				// Skybox #001e0f

				const sky = new Sky();
				sky.scale.setScalar( 10000 );
				scene.add( sky );

				const skyUniforms = sky.material.uniforms;

				skyUniforms[ 'turbidity' ].value = 10;
				skyUniforms[ 'rayleigh' ].value = 2;
				skyUniforms[ 'mieCoefficient' ].value = 0.005;
				skyUniforms[ 'mieDirectionalG' ].value = 0.8;

				const parameters = {
					elevation: 2,
					azimuth: 220
				};

				const pmremGenerator = new THREE.PMREMGenerator( renderer );
				let renderTarget;

				function updateSun() {

					const phi = THREE.MathUtils.degToRad( 93.7 - parameters.elevation );
					const theta = THREE.MathUtils.degToRad( parameters.azimuth );

					sun.setFromSphericalCoords( 1, phi, theta );

					sky.material.uniforms[ 'sunPosition' ].value.copy( sun );
					water.material.uniforms[ 'sunDirection' ].value.copy( sun ).normalize();

					if ( renderTarget !== undefined ) renderTarget.dispose();

					renderTarget = pmremGenerator.fromScene( sky );

					scene.environment = renderTarget.texture;

				}

				updateSun();

				//cube
                const cubeTexture = new THREE.TextureLoader().load('/pub/img/dalle-image1256.jpg');
				const geometry = new THREE.BoxGeometry( 30, 30, 30 );
				//const material = new THREE.MeshStandardMaterial( { roughness: 0 } );
				const material =  new THREE.MeshLambertMaterial({ map: cubeTexture });

				mesh = new THREE.Mesh( geometry, material );
				scene.add( mesh );

				//ambiant light
                    const ambientLight = new THREE.AmbientLight(0x909090);
                    scene.add(ambientLight);

				/* controls = new OrbitControls( camera, renderer.domElement );
				controls.maxPolarAngle = Math.PI * 0.495;
				controls.target.set( 0, 10, 0 );
				controls.minDistance = 40.0;
				controls.maxDistance = 200.0;
				controls.update(); */

				//

				/* stats = new Stats();
				container.appendChild( stats.dom ); */

				// GUI

				/* const gui = new GUI();
				const folderSky = gui.addFolder( 'Sky' );
				folderSky.add( parameters, 'elevation', 0, 90, 0.1 ).onChange( updateSun );
				folderSky.add( parameters, 'azimuth', - 180, 180, 0.1 ).onChange( updateSun );
				folderSky.open();

				const waterUniforms = water.material.uniforms;

				const folderWater = gui.addFolder( 'Water' );
				folderWater.add( waterUniforms.distortionScale, 'value', 0, 8, 0.1 ).name( 'distortionScale' );
				folderWater.add( waterUniforms.size, 'value', 0.1, 10, 0.1 ).name( 'size' );
				folderWater.open(); */

				//

				window.addEventListener( 'resize', onWindowResize );

			}

			function onWindowResize() {

				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();

				renderer.setSize( window.innerWidth, window.innerHeight );

			}
              
			function animate() {

				requestAnimationFrame( animate );
				render();
				//stats.update();

			}

			function render() {

				const time = performance.now() * 0.001;

				mesh.position.y = Math.sin( time ) * 20 + 5;
				mesh.rotation.x = time * 0.5;
				mesh.rotation.z = time * 0.51;

				water.material.uniforms[ 'time' ].value += 1.0 / 60.0;

                // Assuming 'objectToOrbit' is your target object and 'camera' is your THREE.Camera


                // Increment the angle
                //angle += speed;

                // Calculate new camera position
                //camera.position.x = radius * Math.sin(angle);
                //camera.position.z = radius * Math.cos(angle);
                //camera.position.y = mesh.position.y + 18;

                // Make the camera look at the object
                //camera.lookAt(0,0,0);

                //renderer.render(scene, camera);



				renderer.render( scene, camera );

			}