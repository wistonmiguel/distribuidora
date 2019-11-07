<!DOCTYPE html>

<html>

<head>

	<title>Hi</title>

</head>

<body>

<div>
    <div>
        <div class="form-group">
            <!-- MODEL_ATTR -->

            <h1>Distribuidora Nueva Inglaterra</h1>
            <h3>Clientes que Compran al Menudeo</h3>
            <div class="row">
                <table class="table" id="tablaDetalle" border="1" style="width: 100%;">
                    <thead class="thead-dark">
                        <tr style="background-color: DarkBlue; color: white; text-align: center;">
                        <!-- MODEL_ATTR -->
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Factura</th>
                        <th>Producto</th>
                        <th>Distribucion</th>
                        <th>Cantidad</th>
                        <th>Precio de Compra</th>
                        <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sum=0;
                            $total=0;
                        @endphp

                        @foreach ($data_model as $model)

                            @php
                                $total += ($model->Cantidad * $model->Precio);
                            @endphp

                        <tr style="text-align: center;">
                            <td>{{ $model->NCli }}</td>
                            <td>{{ $model->FechaESP }}</td>
                            <td> @php if($model->Factura) echo $model->Factura; else echo 'N/A' @endphp </td>
                            <td style="text-align: left;">{{ $model->Descripcion }}</td>
                            <td>{{ $model->Distribucion }}</td>
                            <td>{{ $model->Cantidad }}</td>
                            <td>C$ {{ sprintf('%0.2f', $model->Precio) }} </td>
                            <td>C$ {{ sprintf('%0.2f', $model->Cantidad * $model->Precio) }} </td>
                        </tr>
                        @endforeach
                        <tr style="text-align: center;">
                        <td colspan="5"></td>
                        <td colspan="2">Venta Total en Productos al Menudeo</td>
                        <td>C$ @php echo sprintf('%0.2f', $total) @endphp</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            </div>

        </div>
    </div>

</body>

</html>
