<h2>Add task</h2>
<form enctype="multipart/form-data" method="post">
    <div class="form-group">
        <label for="inputUsername">User name</label>
        <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Name">
    </div>
    <div class="form-group">
        <label for="inputEmail">Email address</label>
        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="name@example.com">
    </div>
    <div class="form-group">
        <label for="inputDescription">Task description</label>
        <textarea class="form-control" id="inputDescription" name="description" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="inputImageFile">Image file</label>
        <input type="file" accept=".jpg, .jpeg, .gif, .png" id="inputImageFile" name="file">
        <p class="help-block">Supports jpg/gif/png files only.</p>
    </div>
    <button class="btn btn-default" id="preview-button">Preview</button>
    <button type="submit" class="btn btn-primary">Add</button>
</form>
<div class="preview-content"></div>

<script>
    $(function () {
        $("#preview-button").click(function() {
            var fileData = $('#inputImageFile').prop('files')[0];
            var formData = new FormData();
            formData.append('file', fileData);
            formData.append('username', $("#inputUsername").val());
            formData.append('email', $("#inputEmail").val());
            formData.append('description', $("#inputDescription").val());

            $.ajax({
                url : "/task/view",
                type: "POST",
                data : formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $(".preview-content").html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Preview fail: " + textStatus + " - " + errorThrown);
                }
            });
            return false;
        });
    });
</script>