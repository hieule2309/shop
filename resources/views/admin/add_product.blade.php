<!DOCTYPE html>
<html>
  <head> 
        @include('admin.css')
        <style type="text/css">
            .div_deg{
                display: flex;
                justify-content: center;
                align-items: center;
                margin-top: 60px;
            }
            h1{
                color: white;
            }
            label{
                display: inline-block;
                width: 200px;
                font-size: 18px !important;
                color: white !important;
            }
            input[type='text']{
                width: 350px;
                height: 50px;
            }
            textarea{
                width: 450px;
                height: 80px;
            }
            .input_deg{
                padding: 15px;
            }
        </style>
  </head>
  <body>
        @include('admin.header')
    <div class="d-flex align-items-stretch">

        @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h1>Add Product</h1>
            <div class="div_deg">
                <form action="{{url('upload_product')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="input_deg">
                        <label for="">Product Title</label>
                        <input type="text" name="title" required>
                    </div>
                    <div class="input_deg">
                        <label for="">Description</label>
                        <textarea name="description" required></textarea>
                    </div>
                    <div class="input_deg">
                        <label for="">Price</label>
                        <input type="text" name="price" required>
                    </div>
                    <div class="input_deg">
                        <label for="">Quantity</label>
                        <input type="number" name="qty" required>
                    </div>
                    <div class="input_deg">
                        <label for="">Product Category</label>
                        <select name="category" id="" required>
                            <option value="">Choose</option>
                            @foreach($category as $category)
                            <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input_deg">
                        <label for="">Product Options</label>
                        <div id="product-options">
                            <div class="option">
                                <input type="text" name="options[]" placeholder="Option Name" required>
                                <input type="text" name="options_price[]" placeholder="Option Price" required>
                                <input type="text" name="options_quantity[]" placeholder="Option quantity" required>
                                <div class="image-container">
                                    <input type="file" name="options_image[0][]" multiple onchange="previewImages(this)"> <!-- Upload multiple images for the first option -->
                                </div>
                                <div class="image-preview" style="display: flex; flex-wrap: wrap; margin-top: 10px;"></div> <!-- Container for image previews -->
                            </div>
                        </div>
                        <button type="button" onclick="addOption()">Add More Options</button> <!-- Button to add more options -->
                    </div>
                    <div class="input_deg">
                        <input class="btn btn-success" type="submit" value="Add Product">
                    </div>
                </form>
            </div>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset('/admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('/admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('/admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('/admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('/admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('/admincss/js/front.js')}}"></script>
    <script>
        let optionCount = 1; // Initialize a counter for options

        function addOption() {
            const optionsDiv = document.getElementById('product-options');
            const newOption = document.createElement('div');
            newOption.classList.add('option');
            newOption.innerHTML = `
                <input type="text" name="options[]" placeholder="Option Name" required>
                <input type="text" name="options_price[]" placeholder="Option Price" required>
                <input type="text" name="options_quantity[]" placeholder="Option Quantity" required>
                <div class="image-container">
                    <input type="file" name="options_image[${optionCount}][]" multiple onchange="previewImages(this)"> <!-- Upload multiple images for each new option -->
                </div>
                <div class="image-preview" style="display: flex; flex-wrap: wrap; margin-top: 10px;"></div> <!-- Container for image previews -->
            `;
            optionsDiv.appendChild(newOption);
            optionCount++; // Increment the counter for the next option
        }

        function previewImages(input) {
            const previewContainer = input.parentElement.nextElementSibling; // Get the next sibling (image preview container)
            previewContainer.innerHTML = ''; // Clear previous previews

            const files = input.files; // Get the selected files
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = function (e) {
                    const imgContainer = document.createElement('div');
                    const img = document.createElement('img');
                    img.src = e.target.result; // Set the image source to the file's data URL
                    img.style.width = '100px'; // Set a fixed width for the preview
                    img.style.marginRight = '10px'; // Add some margin
                    img.style.marginBottom = '10px'; // Add some margin at the bottom

                    const removeButton = document.createElement('button');
                    removeButton.innerText = 'x'; // Create a remove button
                    removeButton.onclick = function() {
                        imgContainer.remove(); // Remove the image container when clicked
                    };

                    imgContainer.appendChild(img); // Append the image to the container
                    imgContainer.appendChild(removeButton); // Append the remove button to the container
                    previewContainer.appendChild(imgContainer); // Append the image container to the preview
                }
                reader.readAsDataURL(file); // Read the file as a data URL
            }
        }
    </script>
  </body>
</html>