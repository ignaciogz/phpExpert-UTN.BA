<?php
/**
 * PDFGenerator Class 
 * @author Ignacio Gutierrez
 * Clase para generar archivos PDF en tiempo real
*/
class PDFGenerator extends FPDF
{
    public function crearArchivoPDF($productosDelUsuario, $usuario)
    {
        $this->AddPage();
        $this->tablaHorizontal($productosDelUsuario);
        $pathArchivo = "archivos/$usuario/";
        if(!file_exists($pathArchivo))
        {
            mkdir($pathArchivo, 0755);
        }
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $horarioDeEvento = date('Y-m-d_his');

        $pathArchivo = $pathArchivo."notaDePedido_".$horarioDeEvento.".pdf";
        $this->Output($pathArchivo,"F");

        return $pathArchivo;
    }

    private function cabeceraHorizontal()
    {
        //logo de la tienda
        $this->Image('img/pdf/header.jpg' , 0, 0, 210 , 94,'JPG');

        $id_factura=1;
        $fecha_factura="20/12/15";
        // Encabezado de la factura
        $this->SetFont('Arial','B',24);
        $this->SetTextColor(241,241,241);
        $top_datos=60;
        $this->SetY($top_datos);
        $this->Cell(190, 10, utf8_decode("EXPERT X"), 0, 2, "C");
        $this->Cell(190, 10, utf8_decode("NOTA DE PEDIDO"), 0, 2, "C");
        $this->SetFont('Arial','B',12);
        $this->MultiCell(190,5, utf8_decode("Número de nota: $id_factura"."\n"."Fecha: $fecha_factura"), 0, "C", false);
        $this->Ln(2);
    }
 
    private function datosHorizontal($productosDelUsuario)
    {
        // Datos de la tienda
            $this->SetTextColor(0,0,0);
            $this->SetFont('Arial','B',16);
            $top_datos=105;
            $this->SetXY(35, $top_datos);
            $this->Cell(190, 10, utf8_decode("DATOS DE LA TIENDA"), 0, 2, "J");
            $this->SetFont('Arial','',10);
            $this->MultiCell(190, //posición X
            5, //posición Y
            utf8_decode(
            "ID Vendedor: "."1."."\n".
            "Vendedor: "."Mr. X."."\n".
            "Dirección: "."Medrano 951."."\n".
            "Provincia: "."C.A.B.A."."\n".
            "Telefono: "."+54 9 11 4867-7511."."\n".
            "Código Postal: "."1437."),
             0, // bordes 0 = no | 1 = si
             "J", // texto justificado 
             false);


        // Datos del cliente
            $this->SetFont('Arial','B',16);
            $this->SetXY(120, $top_datos);
            $this->Cell(190, 10, utf8_decode("DATOS DEL CLIENTE"), 0, 2, "J");
            $this->SetFont('Arial','',10);
            $this->MultiCell(
            190, //posición X
            5, //posicion Y
            utf8_decode(
            "DNI: "."20.453.557"."\n".
            "Nombre y Apellido: "."Chuck Norris."."\n".
            "Dirección: "."Rivadavia 5227."."\n".
            "Provincia: "."C.A.B.A."."\n".
            "Telefono: "."+54 9 11 4741-7219."."\n".
            "Código Postal: "."3714."),
            0, // bordes 0 = no | 1 = si
            "J", // texto justificado
            false);

        //Salto de línea
        $this->Ln(2);


        //Creación de la tabla de los detalles de los productos productos
        $top_productos = 165;
        $this->SetFont('Arial','B',16);
            $this->SetXY(30, $top_productos);
            $this->Cell(40, 5, utf8_decode('UNIDAD'), 0, 1, 'C');
            $this->SetXY(75, $top_productos);
            $this->Cell(40, 5, utf8_decode('PRODUCTO'), 0, 1, 'C');
            $this->SetXY(115, $top_productos);
            $this->Cell(70, 5, utf8_decode('PRECIO X UNIDAD'), 0, 1, 'C');    
         
        
        $this->SetXY(25, 150);
        $this->SetTextColor(241,241,241);
        $this->Cell(70, 5, '____________________________________________________', 0, 1, 'L');    

        $this->SetTextColor(0,0,0);
        $y = 170; // variable para la posición top desde la cual se empezarán a agregar los datos

        $precioTotal = 0;
        foreach($productosDelUsuario as $productoX)
        {
            $nombreProducto = $productoX['nombre'];
            $precioProducto = $productoX['precio'];
        
            $this->SetFont('Arial','',10);
                   
                $this->SetXY(40, $y);
                $this->Cell(20, 5, utf8_decode("1"), 0, 1, 'C');
                $this->SetXY(80, $y);
                $this->Cell(30, 5, utf8_decode("$nombreProducto"), 0, 1, 'C');
                $this->SetXY(135, $y);
                $this->Cell(30, 5, utf8_decode("$$precioProducto"), 0, 1, 'C');

            // aumento del top 5 cm
            $y = $y + 5;

            $precioTotal += $precioProducto;
        }

        $this->SetFont('Arial','B',16);
        $this->SetXY(100, 215);
        $this->Cell(0, 10, utf8_decode("Gastos de envío: $"."XXXX"), 0, 1, "C");
        $this->SetXY(100, 223);
        $this->Cell(0, 10, utf8_decode("PRECIO TOTAL: $$precioTotal"), 0, 1, "C");

        $this->Image('img/pdf/footer.jpg' , 0, 242, 210 , 55,'JPG');
    }
 
    private function tablaHorizontal($productosDelUsuario)
    {
        $this->cabeceraHorizontal();
        $this->datosHorizontal($productosDelUsuario);
    }
}