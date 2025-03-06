<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login with Three.js Animation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Remix Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        a {
            color: #2983ff;
        }

        #container {
            position: absolute;
            width: 300px;
            height: 300px;
            bottom: 50px;
            right: 50px;
            z-index: 10;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .login-container {
            position: relative;
            width: 100%;
            max-width: 500px;
            padding: 40px;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            z-index: 5;
        }

        .form-container {
            max-width: 100%;
            margin: 0 auto;
            width: 100%;
        }

        .logo-container {
            margin-bottom: 2.5rem;
            max-width: 200px;
        }

        .logo-container img {
            max-width: 100%;
        }

        h4 {
            margin-bottom: 0.75rem;
        }

        .welcome-text {
            color: #6b7280;
            font-size: 1.125rem;
            margin-bottom: 2rem;
        }

        .form-control {
            height: 56px;
            background-color: #f9fafb;
            border-radius: 12px;
        }

        .icon-field {
            position: relative;
            margin-bottom: 1rem;
        }

        .icon-field .icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
            color: #6b7280;
        }

        .icon-field .form-control {
            padding-left: 48px;
        }

        .password-field {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
        }

        .options-row {
            display: flex;
            justify-content: space-between;
            gap: 0.5rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me label {
            margin-left: 0.5rem;
        }

        .forgot-link {
            color: #2563eb;
            font-weight: 500;
            text-decoration: none;
        }

        .btn-login {
            background-color: #2563eb;
            color: white;
            width: 100%;
            border-radius: 12px;
            padding: 1rem 0.75rem;
            margin-top: 2rem;
            font-size: 0.875rem;
            border: none;
        }

        .divider {
            position: relative;
            text-align: center;
            margin-top: 2rem;
        }

        .divider:before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #e5e7eb;
            z-index: 0;
        }

        .divider span {
            position: relative;
            background-color: white;
            z-index: 1;
            padding: 0 1rem;
        }

        .social-buttons {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 2rem;
        }

        .social-button {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem 1.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background-color: transparent;
            color: #4b5563;
            font-weight: 600;
            transition: background-color 0.2s;
        }

        .social-button:hover {
            background-color: #eff6ff;
        }

        .social-button i {
            color: #2563eb;
            font-size: 1.25rem;
        }

        .register-link {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.875rem;
        }

        .register-link a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            #container {
                width: 150px;
                height: 150px;
                bottom: 20px;
                right: 20px;
            }

            .login-container {
                margin: 0 20px;
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="form-container">
            <div class="logo-container text-center">
                <i class="ri-login-box-line" style="font-size: 3rem; color: #2563eb;"></i>
            </div>

            <h4>Inicia Sesión en tu Cuenta</h4>
            <p class="welcome-text">¡Bienvenido de nuevo! Por favor ingresa tus datos</p>
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="icon-field">
                    <span class="icon">
                        <i class="ri-mail-line"></i>
                    </span>
                    <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
                </div>

                <div class="password-field">
                    <div class="icon-field mb-0">
                        <span class="icon">
                            <i class="ri-lock-line"></i>
                        </span>
                        <input type="password" name="password" class="form-control" id="your-password"
                            placeholder="Contraseña" required>
                    </div>
                    <span class="toggle-password ri-eye-line" data-toggle="#your-password"></span>
                </div>

                <div class="options-row">
                    <div class="remember-me">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label for="remember">Recordarme</label>
                    </div>
                    <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn-login">Iniciar Sesión</button>



            </form>
        </div>
    </div>

    <div id="container"></div>

    <script type="importmap">
			{
				"imports": {
					"three": "../build/three.module.js",
					"three/addons/": "./jsm/"
				}
			}
		</script>
    <script type="module">
        import * as THREE from 'three';
        import Stats from 'three/addons/libs/stats.module.js';
        import {
            OrbitControls
        } from 'three/addons/controls/OrbitControls.js';
        import {
            RoomEnvironment
        } from 'three/addons/environments/RoomEnvironment.js';
        import {
            GLTFLoader
        } from 'three/addons/loaders/GLTFLoader.js';
        import {
            DRACOLoader
        } from 'three/addons/loaders/DRACOLoader.js';

        let mixer;
        const clock = new THREE.Clock();
        const container = document.getElementById('container');

        // No need for stats in a login page
        // const stats = new Stats();
        // container.appendChild(stats.dom);

        const renderer = new THREE.WebGLRenderer({
            antialias: true,
            alpha: true
        });
        renderer.setPixelRatio(window.devicePixelRatio);
        renderer.setSize(container.clientWidth, container.clientHeight);
        renderer.setClearColor(0x000000, 0); // Transparent background
        container.appendChild(renderer.domElement);

        const pmremGenerator = new THREE.PMREMGenerator(renderer);

        const scene = new THREE.Scene();
        // Remove background color for transparency
        // scene.background = new THREE.Color(0xbfe3dd);
        scene.environment = pmremGenerator.fromScene(new RoomEnvironment(), 0.04).texture;

        const camera = new THREE.PerspectiveCamera(40, container.clientWidth / container.clientHeight, 1, 100);
        camera.position.set(5, 3, 6);

        const controls = new OrbitControls(camera, renderer.domElement);
        controls.target.set(0, 1, 0);
        controls.update();
        controls.enablePan = false;
        controls.enableZoom = false; // Disable zoom to keep the model in view
        controls.enableDamping = true;
        controls.autoRotate = true;
        controls.autoRotateSpeed = 1.0; // Faster rotation looks better in the small container
        controls.maxPolarAngle = Math.PI / 2;

        const dracoLoader = new DRACOLoader();
        dracoLoader.setDecoderPath('jsm/libs/draco/gltf/');

        const loader = new GLTFLoader();
        loader.setDRACOLoader(dracoLoader);

        loader.load('models/gltf/LittlestTokyo.glb', function(gltf) {
            const model = gltf.scene;
            model.position.set(1, 0.5, 0);
            model.scale.set(0.01, 0.01, 0.01);
            model.rotation.x = Math.PI * 0.05;
            scene.add(model);

            mixer = new THREE.AnimationMixer(model);
            mixer.clipAction(gltf.animations[0]).play();

            renderer.setAnimationLoop(animate);

            // Adjust model and camera to fit the container
            fitCameraToObject(camera, model, controls);

        }, undefined, function(e) {
            console.error(e);

            // Create fallback model if loading fails
            createFallbackModel();
            renderer.setAnimationLoop(animate);
        });

        // Create a fallback model in case the GLTF load fails
        function createFallbackModel() {
            const group = new THREE.Group();

            // Create a stylized city with basic geometry
            const buildingMaterial = new THREE.MeshStandardMaterial({
                color: 0x8899aa,
                metalness: 0.2,
                roughness: 0.8
            });
            const buildingGeometries = [
                new THREE.BoxGeometry(0.5, 1.2, 0.5),
                new THREE.BoxGeometry(0.4, 0.8, 0.4),
                new THREE.BoxGeometry(0.3, 1.5, 0.3),
                new THREE.BoxGeometry(0.6, 0.6, 0.6),
                new THREE.BoxGeometry(0.2, 1.0, 0.2)
            ];

            // Create buildings in a grid pattern
            const gridSize = 3;
            const spacing = 0.7;

            for (let x = -gridSize; x <= gridSize; x++) {
                for (let z = -gridSize; z <= gridSize; z++) {
                    // Skip some positions randomly to create gaps
                    if (Math.random() < 0.2) continue;

                    const geometry = buildingGeometries[Math.floor(Math.random() * buildingGeometries.length)];
                    const building = new THREE.Mesh(geometry, buildingMaterial);

                    building.position.set(
                        x * spacing + (Math.random() * 0.2 - 0.1),
                        geometry.parameters.height / 2,
                        z * spacing + (Math.random() * 0.2 - 0.1)
                    );

                    building.rotation.y = Math.random() * Math.PI * 2;

                    group.add(building);
                }
            }

            // Add a base plane
            const groundGeometry = new THREE.PlaneGeometry(10, 10);
            const groundMaterial = new THREE.MeshStandardMaterial({
                color: 0x66aa66,
                metalness: 0.1,
                roughness: 0.9
            });
            const ground = new THREE.Mesh(groundGeometry, groundMaterial);
            ground.rotation.x = -Math.PI / 2;
            ground.position.y = 0;
            group.add(ground);

            group.position.set(1, 0, 0);
            group.scale.set(0.5, 0.5, 0.5);

            scene.add(group);

            // Create a simple animation
            mixer = new THREE.AnimationMixer(group);
            const rotationTrack = new THREE.NumberKeyframeTrack(
                '.rotation[y]',
                [0, 5, 10],
                [0, Math.PI, Math.PI * 2]
            );

            const animationClip = new THREE.AnimationClip('rotate', 10, [rotationTrack]);
            mixer.clipAction(animationClip).play();

            // Fit camera to this model
            fitCameraToObject(camera, group, controls);
        }

        // Helper function to fit camera to model
        function fitCameraToObject(camera, object, controls) {
            const boundingBox = new THREE.Box3().setFromObject(object);
            const center = boundingBox.getCenter(new THREE.Vector3());
            const size = boundingBox.getSize(new THREE.Vector3());

            // Get the max side of the bounding box
            const maxDim = Math.max(size.x, size.y, size.z);
            const fov = camera.fov * (Math.PI / 180);
            let cameraZ = Math.abs(maxDim / 2 / Math.tan(fov / 2));

            // Set camera position
            cameraZ = cameraZ * 1.5; // Zoom out a bit
            camera.position.set(center.x, center.y + (size.y / 4), center.z + cameraZ);

            // Set orbit controls target to center of model
            const minZ = boundingBox.min.z;
            const cameraToFarEdge = (minZ < 0) ? -minZ + cameraZ : cameraZ - minZ;

            camera.far = cameraToFarEdge * 3;
            camera.updateProjectionMatrix();

            controls.target = center;
            controls.update();
        }

        window.onresize = function() {
            camera.aspect = container.clientWidth / container.clientHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(container.clientWidth, container.clientHeight);
        };

        function animate() {
            const delta = clock.getDelta();
            if (mixer) mixer.update(delta);
            controls.update();
            // stats.update(); // No need for stats in login page
            renderer.render(scene, camera);
        }
    </script>

    <!-- jQuery for password toggle functionality -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        // Password Show Hide
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('.toggle-password');
            togglePassword.addEventListener('click', function() {
                this.classList.toggle('ri-eye-off-line');
                const input = document.querySelector(this.getAttribute('data-toggle'));
                if (input.getAttribute('type') === 'password') {
                    input.setAttribute('type', 'text');
                } else {
                    input.setAttribute('type', 'password');
                }
            });
        });
    </script>
</body>

</html>
