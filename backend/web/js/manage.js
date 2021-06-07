function generateApples()
{
    $.ajax({
        'url': '/index.php?r=apple/generate',
        'method': 'post',
        success: function(response){
            if (response.success !== undefined) {
                let alert = $('#alert');
                alert.html('<div class="alert alert-success" role="alert">' + response.success + '</div>')
            } else {
                let alert = $('#alert');
                alert.html('<div class="alert alert-danger" role="alert">' + response.error + '</div>')
            }
        }
    });
}

function eatApple(id) {

    let sizeVal = $('#' + id);

    $.ajax({
        'url': '/index.php?r=apple/eat-apple',
        'method': 'post',
        'data': {'apple_id': id, 'size': sizeVal.val()},

        success: function(response){
            if (response.success !== undefined) {
                let alert = $('#alert');
                alert.html('<div class="alert alert-success" role="alert">' + response.success + '</div>')
            } else {
                let alert = $('#alert');
                alert.html('<div class="alert alert-danger" role="alert">' + response.error + '</div>')
            }
        }
    });
}

function shakeTree() {

    $.ajax({
        'url': '/index.php?r=apple/shake-tree',
        'method': 'post',
        success: function(response){
            if (response.success !== undefined) {
                let alert = $('#alert');
                alert.html('<div class="alert alert-success" role="alert">' + response.success + '</div>')
            } else {
                let alert = $('#alert');
                alert.html('<div class="alert alert-danger" role="alert">' + response.error + '</div>')
            }
        }
    });
}