    import * as THREE from 'three';
    import { GLTFLoader } from '/api/three.js/examples/jsm/loaders/GLTFLoader.js';
    /* import { OBJLoader } from '/api/three.js/examples/jsm/loaders/OBJLoader.js';
    import { MTLLoader } from '/api/three.js/examples/jsm/loaders/MTLLoader.js'; */
    var scripts = document.getElementsByTagName('script');
    var lastScript = scripts[scripts.length-1];
    var scriptName = lastScript;
    var image_src = scriptName.getAttribute('data-bg3');

    // Scene setup
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, 330 / 330, 0.1, 1000);
    //const renderer = new THREE.WebGLRenderer();
    const renderer = new THREE.WebGLRenderer({
      canvas: document.querySelector('#dw3_catbot_canvas'),antialias: true, alpha: true
    });
    renderer.setSize(330, 330);
    //document.body.appendChild(renderer.domElement);

    // Lighting
    const ambientLight = new THREE.AmbientLight(0x999999);
    scene.add(ambientLight);
    const pointLight = new THREE.PointLight(0xffffff, 0.5);
    pointLight.position.set(5, 5, 5);
    scene.add(pointLight);

    //robot
    const loader = new GLTFLoader();
    loader.load(
      '/pub/scene/RobotTalk/robot1.glb', // Update this path
      (gltf) => {
        const model = gltf.scene;

        //model.scale.set(1.3, 1.3, 1.3); 
        //model.position.set(2.3, 0.5, -20); 
        //model.rotation.y = Math.PI; 
        model.receiveShadow = true;
        model.castShadow = true;
        scene.add(gltf.scene);

      },
      undefined,
      (error) => {
        console.error('An error occurred loading the GLB model:', error);
      }
    );

    // Robot head (rounded cube)
    /* const headGeometry = new THREE.BoxGeometry(1, 1, 1);
    const headMaterial = new THREE.MeshPhongMaterial({ 
        color: 0x6b7280,
        shininess: 100,
        specular: 0x222222
    });
    const head = new THREE.Mesh(headGeometry, headMaterial);
    scene.add(head);

    // Antennas
    const antennaGeometry = new THREE.CylinderGeometry(0.02, 0.02, 0.4, 8);
    const antennaMaterial = new THREE.MeshPhongMaterial({ color: 0x4b5563 });
    
    const leftAntenna = new THREE.Mesh(antennaGeometry, antennaMaterial);
    leftAntenna.position.set(-0.3, 0.8, 0);
    leftAntenna.rotation.z = 0.3;
    head.add(leftAntenna);

    const rightAntenna = new THREE.Mesh(antennaGeometry, antennaMaterial);
    rightAntenna.position.set(0.3, 0.8, 0);
    rightAntenna.rotation.z = -0.3;
    head.add(rightAntenna);

    // Antenna tips
    const tipGeometry = new THREE.SphereGeometry(0.05, 16, 16);
    const tipMaterial = new THREE.MeshPhongMaterial({ color: 0xff0000 });
    
    const leftTip = new THREE.Mesh(tipGeometry, tipMaterial);
    leftTip.position.set(0, 0.2, 0);
    leftAntenna.add(leftTip);

    const rightTip = new THREE.Mesh(tipGeometry, tipMaterial);
    rightTip.position.set(0, 0.2, 0);
    rightAntenna.add(rightTip);

    // Eyes (with pupils)
    const eyeGeometry = new THREE.SphereGeometry(0.15, 32, 32);
    const eyeMaterial = new THREE.MeshPhongMaterial({ color: 0xffffff });
    
    const leftEye = new THREE.Mesh(eyeGeometry, eyeMaterial);
    leftEye.position.set(-0.25, 0.2, 0.45);
    head.add(leftEye);

    const rightEye = new THREE.Mesh(eyeGeometry, eyeMaterial);
    rightEye.position.set(0.25, 0.2, 0.45);
    head.add(rightEye);

    // Pupils
    const pupilGeometry = new THREE.SphereGeometry(0.06, 16, 16);
    const pupilMaterial = new THREE.MeshPhongMaterial({ color: 0x000000 });
    
    const leftPupil = new THREE.Mesh(pupilGeometry, pupilMaterial);
    leftPupil.position.set(0, 0, 0.1);
    leftEye.add(leftPupil);

    const rightPupil = new THREE.Mesh(pupilGeometry, pupilMaterial);
    rightPupil.position.set(0, 0, 0.1);
    rightEye.add(rightPupil);

    // Mouth
    const mouthGeometry = new THREE.BoxGeometry(0.4, 0.1, 0.1);
    const mouthMaterial = new THREE.MeshBasicMaterial({ color: 0x222222 });
    const mouth = new THREE.Mesh(mouthGeometry, mouthMaterial);
    mouth.position.set(0, -0.25, 0.51);
    head.add(mouth); */

    // Camera position
    camera.position.z = 1;
    //camera.position.x = 1;
    camera.position.y = .6;
    camera.rotation.x = -0.35;

    // Animation variables
    /* let mouthOpen = false;
    let mouthTimer = 0;
    const mouthSpeed = 0.08;
    const maxMouthOpen = 0.62;
    let eyeBlinkTimer = 0;
    const blinkInterval = 3;
    let isBlinking = false; */

    // Animation loop
    function animate() {
        requestAnimationFrame(animate);

        // Mouth animation
        /* mouthTimer += mouthSpeed;
        if (mouthTimer > 1) {
            mouthTimer = 0;
            mouthOpen = !mouthOpen;
        }

        // Smooth mouth movement
        const targetScaleY = mouthOpen ? maxMouthOpen : 0.1;
        mouth.scale.y += (targetScaleY - mouth.scale.y) * 0.1; */

        // Antenna wobble
        /* const wobble = Math.sin(Date.now() * 0.005) * 0.1;
        leftAntenna.rotation.z = 0.3 + wobble;
        rightAntenna.rotation.z = -0.3 - wobble; */

        // Eye blink
        /* eyeBlinkTimer += 0.016;
        if (eyeBlinkTimer > blinkInterval && !isBlinking) {
            isBlinking = true;
            eyeBlinkTimer = 0;
        }
        if (isBlinking) {
            const blinkPhase = Math.sin(eyeBlinkTimer * 10);
            leftEye.scale.y = Math.max(0.1, blinkPhase);
            rightEye.scale.y = Math.max(0.1, blinkPhase);
            if (eyeBlinkTimer > 0.3) {
                isBlinking = false;
                eyeBlinkTimer = 0;
            }
        }

        // Pupil movement (looking around)
        const pupilWobble = Math.sin(Date.now() * 0.001) * 0.03;
        leftPupil.position.x = pupilWobble;
        rightPupil.position.x = pupilWobble; */

        renderer.render(scene, camera);
    }

    animate();

    // Handle window resize
    window.addEventListener('resize', () => {
        camera.aspect = 330/330;
        camera.updateProjectionMatrix();
        renderer.setSize(330, 330);
    });