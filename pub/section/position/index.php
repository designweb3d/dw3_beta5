
<div id='svg-tree'></div>

<script>
    const data = {
    "id": "idA",
    "name": "A",
    "children": [
       {
         "id": "idB",
         "name": "B",
         "children": [
           {
             "id": "idC",
             "name": "C"
           },
           {
              "id": "idD",
              "name": "D"
           }
        ]
       }
    ]
  };
  
  const options = {
     width: 400,
     height: 400,
     nodeWidth: 120,
     nodeHeight: 80,
     childrenSpacing: 50,
     siblingSpacing: 20,
     direction: 'top',
     canvasStyle: 'border: 0px solid black; background: rgba(0,0,0,0);',
   };
  
   const tree = new ApexTree(document.getElementById('svg-tree'), options);
   const graph = tree.render(data);
</script>