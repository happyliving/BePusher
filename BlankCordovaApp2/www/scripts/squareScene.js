var squareScene = function(reduction,length,width,height,scene)
{

    var obj = [];
   
    var standary = 100;


    if (length > width) {
        reduction.r = length / standary;
        
        length = length / reduction.r;
        width = width / reduction.r;
    }
    else {
        reduction.r = width / standary;
        length = length / reduction.r;
        width = width / reduction.r;
    }

    console.log(length);
    console.log(width);
    var geometry = new THREE.BoxGeometry(length, width / 100, width);
    var material = new THREE.MeshLambertMaterial({ color: 0xEE7700 });
    var loader = new THREE.TextureLoader();
    var floor = new THREE.Mesh(geometry, material);
    var texture = loader.load("images/wood-floor.jpg", function () {
       
        floor.material.map = texture;
        obj[obj.length] = floor;
        scene.add(floor);
    });

    
    
    

    geometry = new THREE.BoxGeometry(length, height, width / 100);
    material = new THREE.MeshLambertMaterial({ color: 0xffffff });
    var wall = new THREE.Mesh(geometry, material);
    texture = loader.load("images/whiteWall.jpg", function () {
      
        wall.material.map = texture;
        wall.position.set(0, height / 2, -width / 2);
        obj[obj.length] = wall;
        scene.add(wall);
    });

    geometry = new THREE.BoxGeometry(width / 100, height, width);
    material = new THREE.MeshLambertMaterial({ color: 0xffffff });
    var wall2 = new THREE.Mesh(geometry, material);
    texture = loader.load("images/whiteWall.jpg",function () {
        
        wall2.material.map = texture;
        wall2.position.set(length / 2, height / 2, 0);
        obj[obj.length] = wall2;
        scene.add(wall2);
    });
    
    geometry = new THREE.BoxGeometry(width / 100, height, width);
    material = new THREE.MeshLambertMaterial({ color: 0xffffff });
    var wall3 = new THREE.Mesh(geometry, material);
    texture = loader.load("images/whiteWall.jpg", function () {
       
        wall3.material.map = texture;
        wall3.position.set(-length / 2, height / 2, 0);
        obj[obj.length] = wall3;
        scene.add(wall3);
    },function (xhr) {
        console.log((xhr.loaded / xhr.total * 100) + '% loaded');
    },
        // Function called when download errors
        function (xhr) {
            console.log('An error happened');
        });
   

   
       

 
    return obj;
    
   
   
   

   
    
    
}