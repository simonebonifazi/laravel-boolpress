const placeholder = "https://image.shutterstock.com/image-vector/ui-image-placeholder-wireframes-apps-260nw-1037719204.jpg";
const preview = document.getElementById('preview');
const imageField = document.getElementById('image');

imageField.addEventListener('input', () => {
   if(imageField.files && imageField.files[0]){
      let reader = new FileReader();
      reader.readAsDataURL(imageField.files[0]);
      reader.onload = event => {
         preview.src = event.target.result;
      };
   } else preview.src = placeholder;
})
