<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Generator AI</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
    #loader{display:none;text-align:center;}
    </style>
</head>

<body class="bg-light">

<div class="container py-5">

    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="fw-bold">AI Content Generator</h1>
        <p class="text-muted">Generate high-quality content effortlessly using AI</p>
    </div>

    <!-- Card -->
    <div class="card shadow-lg border-0">
        <div class="card-body p-4">
            <form class="mb-4" id="aiform">
                <div class="mb-3 d-flex justify-content-end">
                    <a href="../src/history.php" class="btn btn-warning btn-sm">View History</a>
                </div>
                <!-- Prompt -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Enter Prompt</label>
                    <textarea class="form-control" id="prompt" rows="4" placeholder="Type your prompt here..."></textarea>
                </div>

                <div class="mb-3">
                    <select name="content_type" id="content_type" class="form-control">
                        <option value="" disabled selected>Select Content Type</option>
                        <option value="Policy Draft">Policy Draft</option>
                        <option value="Risk Management">Risk Management</option>
                        <option value="Internal Audit Observation">Internal Audit Observation</option>
                        <option value="CAPA Suggestion">CAPA Suggestion</option>
                        <option value="ISO Scope Statement">ISO Scope Statement</option>
                        <option value="Vendor Assessment Summary">Vendor Assessment Summary</option>
                    </select>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" id="generate-btn" class="btn btn-primary">
                        Generate Content
                    </button>
                    <br>
                    <button type="button" id="save-btn" class="btn btn-secondary">
                       Save
                    </button>
                </div>
            </form> 

            <!-- Output -->
             <hr/>

             <!-- Loader -->
            <div id="loader" class="mt-3">
            <div class="spinner-border text-primary"></div>
            <p>Generating...</p>
            </div>
            
            <div style="display: none;" id="output-section">
                <div class="d-flex justify-content-end mb-2">
                    <button class="btn btn-info" onclick="regenerateResponse();">
                        Regenerate Response
                    </button>
                </div>
                
                <div>
                    <label class="form-label fw-semibold">Generated Content</label>
                    <textarea id="ckeditor"></textarea>
                </div>
                
            </div>
            

        </div>
    </div>

</div>

<!-- CKEditor -->
<!-- <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script> -->
<script src="./../assets/ckeditor/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    // For CKEditor 4
    window.onload = function () {
        CKEDITOR.replace('ckeditor');  
    } 

    function generateContent(prompt) {
        $("#loader").show();
        $("#output-section").hide();

        var content_type = $("#content_type").val();
        console.log("Selected content type: ", content_type);
        $.ajax({
            url: "../src/generate_content.php",
            method: "POST",
            data: { prompt: prompt, content_type: content_type },
            success: function(response) {
                console.log("res=> ",response);
                if(response.includes("API Error") || response.includes("Unexpected Response")){
                    alert("Error generating content. Please try again.");    
                    // alert("Error details: " + response);
                    $("#loader").hide();
                    // $("#output-section").hide();
                    return;
                }

                $("#loader").hide();
                $("#output-section").show();
                
                // let ai_formatted_response = marked.parse(response);
                // CKEDITOR.instances['ckeditor'].setData(ai_formatted_response);

                let formattedResponse = marked.parse(response);
                let finalOutput = `
                    <h2 style="font-weight:bold; margin-bottom:10px;">
                        ${prompt}
                    </h2>
                    <hr>
                    ${formattedResponse}
                `;

                CKEDITOR.instances['ckeditor'].setData(finalOutput);
            },
            error: function() {
                alert("An error occurred while generating content.");
            }
        });
    }


    $("#aiform").submit(function(e) {
        // alert("Form submitted");
        e.preventDefault();
        var prompt = $("#prompt").val();
        if(prompt == null || prompt == undefined || prompt == "")   {
            alert("Prompt is empty! Enter a valid prompt.");
            return; 
        }
        console.log("Prompt: " + prompt);
        generateContent(prompt);
    });


    function regenerateResponse(){
        let prompt=$("#prompt").val();
        if(!prompt){alert("Enter prompt");return;}

        generateContent(prompt);
    }

    $("#save-btn").click(function() {
        let prompt = $("#prompt").val();
        let content_type = $("#content_type").val();
        if(prompt == null || prompt == undefined || prompt == "")   {       
            alert("Prompt is empty! Enter a valid prompt.");
            return; 
        }
        console.log("PROMT to save:",prompt);
        let content = CKEDITOR.instances['ckeditor'].getData();
        console.log("Content to save: ", content);
         if(content.includes("API Error") || content.includes("Unexpected Response")){
            alert("Could not save content. Error generating content! Please try again.");
            return;
        }
        $.ajax({
            url: "../src/save_content.php",
            method: "POST",
            data: { prompt: prompt, content_type: content_type, content: content },
            success: function(response) {
                alert(response);
            },
            error: function() {
                alert("An error occurred while saving content.");
            }
        });
    });

    


</script>


</body>
</html>