  /* customers */
  var jsonAPIUrl = "http://localhost:8000/server.php";

  var app = {

      insertData: function() {
          $.ajax({
              url: jsonAPIUrl,
              method: "post",
              data: {
                  insert_data: 1,
                  message: $('#message').val().trim(),
                  name: $('#name').val().trim(),
                  email: $('#emailAddress').val().trim(),
              },
              async: true,
              dataType: "json",
              success: alert('Köszönöm'),
              error: function(xhr, ajaxOptions, thrownError) {}
          });

      },

      postForm: function() {
          app.insertData();
      },
      paginateData: function(page) {
          var limit = parseInt(page * 10);
          var offset = parseInt((page - 1) * 10);
          app.renderData(limit, offset);
      },
      renderData: function(limit = 10, offset = 0) {
          $('.list_messages').empty();
          $.getJSON(jsonAPIUrl + "?display=1&limit=" + limit + "&offset=" + offset, function(data) {
              var items = [];


              $.each(data, function(item, val) {

                  if (val.name) {
                      let datastr = '<div class="message"><h1>' + val.name + '</h1><h2>Email:' + val.email + '</h2><h3>Üzenet:</h3><p>' + val.message + '</p></div>';
                      items.push(datastr);

                  }
              });

              $("<div/>", {
                  "class": "my-new-list",
                  html: items.join("")
              }).appendTo(".list_messages");
              app.renderPagination(data);
          });

      },
      renderPagination: function(data) {
        var lista = '';
          for (var n = 1; n < data.page; n++) {
               lista += '<li class=\"page-item\"><a class=\"page-link\" href="#" onclick=\"(paginate(' + n + '))\" >' + n + '</a></li>';
          }
          $('.list_messages').append('<nav aria-label=\"Page navigation example\"><ul class=\"pagination\"><li class=\"page-item\"><a class=\"page-link\" href="#" onclick=\"(paginate(1))\">1</a></li>' + lista + '<li class=\"page-item\"><a class=\"page-link\" href="#" onclick=\"(paginate(' + data.page + '))\">' + data.page + '</a></li></ul></nav>');
      },

  }

  $(document).ready(function() {

      renderdata = function() {
          app.renderData()
      };
      paginate = function(page) {
          app.paginateData(page)
      };
      $('#contactForm').captcha();
      $("#contactForm").submit(function(e) {
          e.preventDefault();
          if (!verifyCaptcha('#contactForm')) {
              alert('Használd a Captchát!');
          } else {
              $("#contactForm").validate({
                  rules: {
                      name: {
                          required: true,
                          minlength: 3
                      },
                      message: {
                          required: true,
                          min: 5
                      },
                      emailAddress: {
                          required: true,
                          email: true
                      },

                  },
                  success: function() {
                      app.postForm();
                  }
              });
              app.postForm();
          }

      });

  });