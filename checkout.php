<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.paypal.com/sdk/js?client-id=AaCgAYzdP-cNcfqOyveGX2QlXv91RQ8mMvYsfR1hH6eGyRfUC6Ntgp912ASkWhUjE5v2Zl99d5WhqX3y&currency=MXN"></script>
    <title>Document</title>
</head>
<body>
    <div id="paypal-button-container"></div>

    <script>
        paypal.Buttons({
            style:{
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: 100
                        }
                    }]
                })
            },
            onApprove: function(data, actions){
                actions.order.capture().then(function (detalles){
                    alert('Gracias por su compra')
                })
            }
            ,
            onCancel: function(data){
                alert('Pago cancelado')
            }
        }).render('#paypal-button-container')
    </script>
</body>
</html>