<?php
header("Content-type: image/png");
//header("Content-Disposition: attachment;Content-type: image/png");
function draw_axises($im_width,$im_heignt)
{
	global $im, $green, $l_grey, $x0, $y0, $maxX, $maxY;
	$x0=25.0; //начало оси координат по X
	$y0=20.0; //начало оси координат по Y
	$maxX=$im_width-$x0;  //максимальное значение оси координат по X в пикселах
	$maxY=$im_heignt-$y0; //максимальное значение оси координат по Y в пикселах
	imageline($im, $x0, $maxY, $maxX, $maxY, $green); //рисуем ось X
	imageline($im, $x0, $y0, $x0, $maxY, $green);     //рисуем ось Y
 
	//рисуем стрелку на оси X
	$xArrow[0]=$maxX-6; $xArrow[1]=$maxY-2;
	$xArrow[2]=$maxX; $xArrow[3]=$maxY;
	$xArrow[4]=$maxX-6; $xArrow[5]=$maxY+2;
	imagefilledpolygon($im, $xArrow, 3, $green);
	//рисуем стрелку на оси Y
	$yArrow[0]=$x0-2; $yArrow[1]=$y0+6;
	$yArrow[2]=$x0; $yArrow[3]=$y0;
	$yArrow[4]=$x0+2; $yArrow[5]=$y0+6;
	imagefilledpolygon($im, $yArrow, 3, $green);
}
function draw_grid($xStep,$yStep,$xCoef,$yCoef)
{
	global $im,$black_green,$black_pink,$x0,$y0,$maxX,$maxY;
	$xSteps=($maxX-$x0)/$xStep-1; //определяем количество шагов по оси X
	$ySteps=($maxY-$y0)/$yStep-1; //определяем количество шагов по оси Y
 
	for($i=1;$i<$xSteps+1;$i++)   //выводим сетку по оси X
		{
		imageline($im, $x0+$xStep*$i, $y0, $x0+$xStep*$i, $maxY-1, $black_pink);
		//при необходимости выводим значения линий сетки по оси X
		ImageString($im, 1, ($x0+$xStep*$i)-1, $maxY+2, $i*$xCoef, $black_green);
 
		}
	for($i=1;$i<$ySteps+1;$i++)
		{
		imageline($im, $x0+1, $maxY-$yStep*$i, $maxX, $maxY-$yStep*$i, $black_pink);
		//при необходимости выводим значения линий сетки по оси Y
		ImageString($im, 1, 0, ($maxY-$yStep*$i)-3, $i*$yCoef, $black_green);
		} 
}
function draw_data($data_x,$data_y,$points_count,$color)
{
	global $im,$x0,$y0,$maxY,$scaleX,$scaleY;
	for($i=1;$i<$points_count;$i++)
		{
		//рисуем линейный график по точкам из массивов данных
		imageline($im, $x0+$data_x[$i-1]*$scaleX, $maxY-$data_y[$i-1]*$scaleY, $x0+$data_x[$i]*$scaleX, $maxY-$data_y[$i]*$scaleY, $color);
		}
}
	//создаем рисунок шириной 500 и высотой 400 пикселов
	$im = @imagecreatetruecolor(500, 400);
	$white = ImageColorAllocate ($im, 255, 255, 255);
	$black = ImageColorAllocate ($im, 0, 0, 0);
	$black_green = ImageColorAllocate ($im, 14, 141, 62);
	$green = ImageColorAllocate ($im, 23, 230, 101);
	$blue = ImageColorAllocate ($im, 0, 0, 255);
	$yellow = ImageColorAllocate ($im, 255, 255, 0);
	$pink = ImageColorAllocate ($im, 232, 30, 106);
	$black_pink = ImageColorAllocate($im, 125, 17, 83);
	$cyan = ImageColorAllocate ($im, 0, 255, 255);
	$l_grey = ImageColorAllocate ($im, 200, 200, 200);
 	
 	//imagefill($im, 0, 0, $green);
 	imagecolortransparent($im, $black);
	draw_axises(500,400); //рисуем оси координат
	//задаем массивы данных графиков
	$x1[0]=1; $y1[0]=1;
	$x1[1]=2; $y1[1]=4;
	$x1[2]=3; $y1[2]=8;
	$x1[3]=4; $y1[3]=16;

	$x2[0]=1.5; $y2[0]=2;
	$x2[1]=2.5; $y2[1]=3;
	$x2[2]=3.5; $y2[2]=9;
	$x2[3]=4.5; $y2[3]=17;
 
	//объединяем данные из массивов данных для вычисления масштаба
	$x=array_merge($x1,$x2);
	$y=array_merge($y1,$y2);
	//получаем максимальные значения элементов для каждого массива
	$maxXVal=max($x);
	$maxYVal=max($y);
	//вычисляем масштаб преобразования данных в координаты рабочей области
	$scaleX=($maxX-$x0)/$maxXVal;
	$scaleY=($maxY-$y0)/$maxYVal;
	//задаем шаг для координатной сетки в пикселах
	$xStep=40;
	$yStep=30;
	//рисуем координатную сетку
	draw_grid($xStep,$yStep, round($xStep/$scaleX,1), round($yStep/$scaleY,1), true);
	draw_data($x1,$y1,20,$pink); //рисуем первый график
	//draw_data($x2,$y2,20,$blue); //рисуем второй график
	ImagePNG($im, "public/images/historyActivity/"); //выводим рисунок
	imagedestroy($im); //освобождаем занимаемую рисунком память
?>