
import * as THREE from 'https://unpkg.com/three/build/three.module.js';
import { OrbitControls } from 'https://unpkg.com/three@0.120.1/examples/jsm/controls/OrbitControls.js'

// SCENE AND CAMERA
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 0.1, 1000 );
const renderer = new THREE.WebGLRenderer();
renderer.setSize( window.innerWidth, window.innerHeight );
document.body.appendChild( renderer.domElement );
// WIRE CUBE
const geometry = new THREE.BoxGeometry();
const material = new THREE.MeshBasicMaterial( { color: 0xFF00B6, wireframe: true } );
const cube = new THREE.Mesh( geometry, material );
//scene.add( cube );
// ORBIT CONTROL
const controls = new OrbitControls(camera, renderer.domElement);
// WIRE SPHERE
const geo = new THREE.SphereGeometry(15, 32, 16);
const mat = new THREE.MeshBasicMaterial( { color: 0x5A009C, wireframe: true } )
const torus = new THREE.Mesh(geo, mat);
//scene.add( torus );
// JUSTIN CUBE

const jeffTexture = new THREE.TextureLoader().load('img/justin.png');

const jeff = new THREE.Mesh(new THREE.BoxGeometry(3, 3, 3), new THREE.MeshBasicMaterial({ map: jeffTexture }));

//scene.add(jeff);

// Moon

const moonTexture = new THREE.TextureLoader().load('img/moon.jpg');
const normalTexture = new THREE.TextureLoader().load('img/normal.jpg');

const moon = new THREE.Mesh(
  new THREE.SphereGeometry(3, 32, 32),
  new THREE.MeshStandardMaterial({
    map: moonTexture,
    normalMap: normalTexture,
  })
  );
scene.add(moon);

moon.position.z = 10;
moon.position.setX(-1);

jeff.position.z = -5;
jeff.position.x = 0;

// GRID
const grid = new THREE.GridHelper(200, 50);
//scene.add( grid );
// LIGHT
const pointLight = new THREE.PointLight(0xffffff)
pointLight.position.set(5,5,5)
const ambientLight = new THREE.AmbientLight(0xffffff);
scene.add(pointLight, ambientLight);
camera.position.z = 5;
// STARS
function addStar() {
  const geo2 = new THREE.SphereGeometry(0.25, 24, 24);
  const mat2 = new THREE.MeshStandardMaterial( { color: 0xffffff } )
  const star = new THREE.Mesh(geo2, mat2);
  const [x, y, z] = Array(3).fill().map(() => THREE.MathUtils.randFloatSpread( 100 ));
  star.position.set(x, y, z);
  scene.add(star);
}
Array(200).fill().forEach(addStar)
const spaceTexture = new THREE.TextureLoader().load('img/space.jpg');
scene.background = spaceTexture;
// SCROLL
function moveCamera() {
  const t = document.body.getBoundingClientRect().top;
  moon.rotation.x += 0.05;
  moon.rotation.y += 0.075;
  moon.rotation.z += 0.05;

  jeff.rotation.y += 0.01;
  jeff.rotation.z += 0.01;
  camera.position.z = t * -0.01;
  camera.position.x = t * -0.0002;
  camera.rotation.y = t * -0.0002;
}
 document.body.onscroll = moveCamera;
 moveCamera();
// ANIMATION
const animate = function () {
    requestAnimationFrame( animate );
    cube.rotation.x += 0.01;
    cube.rotation.y += 0.01;
    torus.rotation.x += 0.01;
    torus.rotation.y += 0.01;
    //controls.update();
    renderer.render( scene, camera );
};
animate();