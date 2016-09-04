<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>

            .container {
              display: flex;
              align-items: center;
              width: 100%;
              height: 100%;
              flex-wrap: wrap;
              justify-content: center;
              align-self: center;
            }

            .content {
                width: 350px;
                height: 350px;
                background: #632f53;
                border-radius: 50%;
                text-align: center;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                border: 10px solid #4c2640;
                animation-duration: 3s;
                animation-name: organ;
                animation-timing-function: ease;
            }

            .brain__enter {
              width: 100%;
              display: flex;
              justify-content: center;
              align-items: center;
            }

            .brain__enter > button {
              width: 150px;
              color: white;
              font-size: 23px;
              outline: none;
              background: #632f53;
              border: 2px solid #4c2640;
              border-radius: 15px;
            }

            .brain__enter > button:active {
              box-shadow:   1px 1px 1px 1px black;
            }

            .title {
              color: white;
              font-weight: bold;
              font-size: 96px;
            }
            @keyframes organ {
              0% {
                transform: scale(0.2);
              }
              25% {
                transform: scale(0.6);
              }

              50% {
                transform: scale(0.4);
              }
              75% {
                transform: scale(0.9);
              }

              75% {
                transform: scale(0.7);
              }
          }

        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Brain</div>
            </div>
            <br/>
            <div class="brain__enter">
              <button type="button" name="button">Enter</button>
            </div>
        </div>
    </body>
</html>
