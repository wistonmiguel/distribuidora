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
            <h3>Ventas en Devolución</h3>
            <div class="row">
                <table class="table" id="tablaDetalle" border="1" style="width: 100%;">
                    <thead class="thead-dark">
                        <tr style="background-color: DarkBlue; color: white; text-align: center;">
                        <!-- MODEL_ATTR -->
                        <th>Fecha</th>
                        <th>No. Factura</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio de Venta</th>
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

                        <tr>
                            <td>{{ $model->FechaESP }}</td>
                            <td>{{ $model->Factura }}</td>
                            <td>{{ $model->NCli }}</td>
                            <td>{{ $model->NVend }}</td>
                            <td>{{ $model->Descripcion }}</td>
                            <td>{{ $model->Cantidad }}</td>
                            <td>C$ {{ $model->Precio }}</td>
                            <td>C$ {{ $model->Cantidad * $model->Precio }} </td>
                        </tr>
                        @endforeach
                        <tr>
                        <td colspan="6"></td>
                        <td>Total Mensual</td>
                        <td>C$ @php echo $total; @endphp</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            </div>

        </div>
    </div>

</body>

</html>
