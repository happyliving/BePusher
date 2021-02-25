showScene = function (length, width, height) {

    var scene, renderer, camera, light, control;
    var t;
    var inner;
    var canvas;
    var beaconArray = [];
    var reduction = function ()
    {
        var r;
    }
   

    function init(){
        scene = new THREE.Scene();
        
        renderer = new THREE.WebGLRenderer({ antialias: true });

        light = new THREE.PointLight({ color: 0xffffff });
        light.position.set(0, 500, 500);
        scene.add(light);


        
        if (length > width)
            max = length;
        else
            max = width;
        if (height > max)
            max = heigth;

        camera = new THREE.PerspectiveCamera(30, 400 / 300, 1, 1000);
       

        camera.position.set(0,200,0);
       
        
        camera.rotateX(-Math.PI / 2);

        //control = new THREE.OrbitControls(camera);

        var urls = [
            'images/px.jpg' ,'images/nx.jpg',
            'images/py.jpg' , 'images/ny.jpg',
            'images/pz.jpg' , 'images/nz.jpg'
        ];
        var reflectionCube = new THREE.CubeTextureLoader().load(urls);
        reflectionCube.format = THREE.RGBFormat;
        scene.background = reflectionCube;

       
       

      
        document.getElementById("showScene").appendChild(renderer.domElement);

       
        renderer.render(scene, camera);
       

        if (t != undefined) {
            for (i = 0; i < t.length; i++)
                scene.remove(t[i]);
        }


        t = new squareScene(reduction, length, width, height, scene);
        

    }

    init();
    animate();

    function animate()
    {
        requestAnimationFrame(animate);
        renderer.render(scene, camera);
    }


    

    this.addBeaconCircle = function (beaconObj) {
        var box = new THREE.Box3().setFromObject(t[0]);
        name = beaconObj.name + beaconObj.major + beaconObj.minor;


        var i = 0;
        for (i = 0; i < beaconArray.length; i++) {
          
            if (beaconArray[i].name == name) {
                scene.remove(scene.getObjectByName(name));
                beaconArray[i] = new beaconCircle(scene, getRandomColor());
                beaconArray[i].position.set(box.min.x + parseInt(beaconObj.x) / reduction.r, box.min.y + parseInt(beaconObj.y) / reduction.r, box.min.z + parseInt(beaconObj.z) / reduction.r);
                beaconArray[i].name = beaconObj.name + beaconObj.major + beaconObj.minor;
                break;
            }
        }

        if (i == beaconArray.length) {
            beacon = new beaconCircle(scene, getRandomColor());
            beacon.position.set(box.min.x + parseInt(beaconObj.x) / reduction.r, box.min.y + parseInt(beaconObj.y) / reduction.r, box.min.z + parseInt(beaconObj.z) / reduction.r);
            beacon.name = beaconObj.name + beaconObj.major + beaconObj.minor;
            beaconArray.push(beacon);
        }
        
    }

    function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

   

    

}
