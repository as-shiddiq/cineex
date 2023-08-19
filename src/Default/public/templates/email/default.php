<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?=$title?></title>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Inter&display=swap');
     img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%; }
      table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
      table td {
          font-family: 'Inter', sans-serif;
          font-size: 14px;
          vertical-align: top; }

      body{
        margin: auto;
        background: #f6f6f6;
        line-height: 1.9;
        -webkit-font-smoothing: antialiased;
        padding: 0;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;


      }
      .body {
        background: #f6f6f6;
        font-family: 'Inter', sans-serif;
        width: 100%; 
      }
      .container{
        margin: 0 auto !important;
        max-width: 580px;
      }
      .wrapper{
        background: #fff;
        box-sizing: border-box;
        display: block;
        margin: 30px auto;
        max-width: 580px;
        padding: 30px;
        border-radius: 20px;
      }
      .text-center{
        text-align: center;
      }
      .header{
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 15px;
      }
      .header h1{
        font-size: .9rem;
        margin: 5px;
        color: #333;
        padding: 0
      }
      .content h2{
        font-size: 1.3rem;
        color: #111;
        font-weight: normal;
      }
      .content p{
        font-size: 14px;
        color:#333;
      }
      .footer{
        text-align: center;
        font-size: 10px;
        color:#888;
        margin: 15px auto 30px;
      }
      .footer a{
        color: #666;
        text-decoration: none
      }
      .powered{
        display: block;
        margin-top: 30px
      }
      .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        margin: 10px 0;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    .btn:hover, .btn:focus {text-decoration: none; } .btn:focus, .btn.focus {outline: 0; box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); } .btn:not(:disabled):not(.disabled) {cursor: pointer; } .btn:not(:disabled):not(.disabled):active, .btn:not(:disabled):not(.disabled).active {background-image: none; } .btn-primary {color: #fff; background-color: #007bff; border-color: #007bff; } .btn-primary:hover {color: #fff; background-color: #0069d9; border-color: #0062cc; } .btn-primary:focus, .btn-primary.focus {box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5); } .btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active, .show > .btn-primary.dropdown-toggle {color: #fff; background-color: #0062cc; border-color: #005cbf; } .btn-primary:not(:disabled):not(.disabled):active:focus, .btn-primary:not(:disabled):not(.disabled).active:focus, .show > .btn-primary.dropdown-toggle:focus {box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5); } .btn-secondary {color: #fff; background-color: #6c757d; border-color: #6c757d; } .btn-secondary:hover {color: #fff; background-color: #5a6268; border-color: #545b62; } .btn-secondary:focus, .btn-secondary.focus {box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.5); } .btn-secondary:not(:disabled):not(.disabled):active, .btn-secondary:not(:disabled):not(.disabled).active, .show > .btn-secondary.dropdown-toggle {color: #fff; background-color: #545b62; border-color: #4e555b; } .btn-secondary:not(:disabled):not(.disabled):active:focus, .btn-secondary:not(:disabled):not(.disabled).active:focus, .show > .btn-secondary.dropdown-toggle:focus {box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.5); } .btn-success {color: #fff; background-color: #28a745; border-color: #28a745; } .btn-success:hover {color: #fff; background-color: #218838; border-color: #1e7e34; } .btn-success:focus, .btn-success.focus {box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5); } .btn-success:not(:disabled):not(.disabled):active, .btn-success:not(:disabled):not(.disabled).active, .show > .btn-success.dropdown-toggle {color: #fff; background-color: #1e7e34; border-color: #1c7430; } .btn-success:not(:disabled):not(.disabled):active:focus, .btn-success:not(:disabled):not(.disabled).active:focus, .show > .btn-success.dropdown-toggle:focus {box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5); } .btn-info {color: #fff; background-color: #17a2b8; border-color: #17a2b8; } .btn-info:hover {color: #fff; background-color: #138496; border-color: #117a8b; } .btn-info:focus, .btn-info.focus {box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.5); } .btn-info:not(:disabled):not(.disabled):active, .btn-info:not(:disabled):not(.disabled).active, .show > .btn-info.dropdown-toggle {color: #fff; background-color: #117a8b; border-color: #10707f; } .btn-info:not(:disabled):not(.disabled):active:focus, .btn-info:not(:disabled):not(.disabled).active:focus, .show > .btn-info.dropdown-toggle:focus {box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.5); } .btn-warning {color: #212529; background-color: #ffc107; border-color: #ffc107; } .btn-warning:hover {color: #212529; background-color: #e0a800; border-color: #d39e00; } .btn-warning:focus, .btn-warning.focus {box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.5); } .btn-warning:not(:disabled):not(.disabled):active, .btn-warning:not(:disabled):not(.disabled).active, .show > .btn-warning.dropdown-toggle {color: #212529; background-color: #d39e00; border-color: #c69500; } .btn-warning:not(:disabled):not(.disabled):active:focus, .btn-warning:not(:disabled):not(.disabled).active:focus, .show > .btn-warning.dropdown-toggle:focus {box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.5); } .btn-danger {color: #fff; background-color: #dc3545; border-color: #dc3545; } .btn-danger:hover {color: #fff; background-color: #c82333; border-color: #bd2130; } .btn-danger:focus, .btn-danger.focus {box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.5); } .btn-danger:not(:disabled):not(.disabled):active, .btn-danger:not(:disabled):not(.disabled).active, .show > .btn-danger.dropdown-toggle {color: #fff; background-color: #bd2130; border-color: #b21f2d; } .btn-danger:not(:disabled):not(.disabled):active:focus, .btn-danger:not(:disabled):not(.disabled).active:focus, .show > .btn-danger.dropdown-toggle:focus {box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.5); } .btn-light {color: #212529; background-color: #f8f9fa; border-color: #f8f9fa; } .btn-light:hover {color: #212529; background-color: #e2e6ea; border-color: #dae0e5; } .btn-link {font-weight: 400; color: #007bff; background-color: transparent; } .btn-link:hover {color: #0056b3; text-decoration: underline; background-color: transparent; border-color: transparent; } .btn-link:focus, .btn-link.focus {text-decoration: underline; border-color: transparent; box-shadow: none; } .btn-lg, .btn-group-lg > .btn {padding: 0.5rem 1rem; font-size: 1.25rem; line-height: 1.5; border-radius: 0.3rem; } .btn-sm, .btn-group-sm > .btn {padding: 0.25rem 0.5rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.2rem; } .btn-block {display: block; width: 100%; } .btn-block + .btn-block {margin-top: 0.5rem; }
    input[type="submit"].btn-block,
    input[type="reset"].btn-block,
    input[type="button"].btn-block {
        width: 100%;
    }
    </style>
  </head>
  <body class="">
    <table border="0" cellpadding="0" cellspacing="0" class="body">
      <tbody>
      <tr>
        <td>&nbsp;</td>
        <td class="container">
      <div class="wrapper">
        <div class="header text-center">
          <img src="<?=$configWeb->config_web_logo_light_url?>" width="150px">
          <br>
          <h1><?=$configWeb->config_web_deskripsi?></h1>
        </div>
        <div class="content">
          <h2><?=$title?></h2>
        <p>
          <?=$message?>
        </p>
        </div>
      </div>

      <div class="footer">
        <div class="footnote"><?=$configEmail->config_email_footnote?></div>
        <div class="footer"><?=$configEmail->config_email_footer?></div>
      </div>
    </td>
    </tr>
    </tbody>
  </table>

  </body>
</html>