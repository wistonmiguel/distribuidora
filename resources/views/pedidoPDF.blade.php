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

            <div class="row">
            <table class="table" id="tablaDetalle" border="1" style="text-align: rigth  ;">
                    <thead class="thead-dark">
                        <tr>
                        <!-- MODEL_ATTR -->
                        <th style="background-color: DarkBlue; color: white; text-align: center;">FACTURA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $data_model[0]['idTransaccion'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <br>

            <div class="row">
                <table class="table" id="tablaDetalle" border="1" style="width: 100%;">
                    <thead class="thead-dark">
                        <tr style="background-color: DarkBlue; color: white; text-align: center;">
                        <!-- MODEL_ATTR -->
                        <th>FECHA</th>
                        <th>ESTADO</th>
                        <th>CLIENTE</th>
                        <th>ORIGEN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $data_model[0]['FechaESP'] }}</td>
                            <td>{{ $data_model[0]['Estado'] }}</td>
                            <td>{{ $data_model[0]['NCli'] }}</td>
                            <td>{{ $data_model[0]['Origen'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <br>

            <div class="row">
                <table class="table" id="tablaDetalle" border="1" style="width: 100%;">
                    <thead class="thead-dark">
                        <tr style="background-color: DarkBlue; color: white; text-align: center;">
                        <!-- MODEL_ATTR -->
                        <th>Codigo</th>
                        <th>Producto</th>
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

                        <tr>
                            <td>{{ $model->idProducto }}</td>
                            <td>{{ $model->Descripcion }}</td>
                            <td>{{ $model->Cantidad }}</td>
                            <td>C$ {{ $model->Precio }}</td>
                            <td>C$ {{ $model->Cantidad * $model->Precio }} </td>
                        </tr>
                        @endforeach
                        <tr>
                        <td colspan="3"></td>
                        <td>Total</td>
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
