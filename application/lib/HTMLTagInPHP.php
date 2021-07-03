<?php  


function ContainerTagShow($tag, ...$arg){
	
	if(count($arg) > 0){
		echo "<".$tag." ";
		foreach($arg as $val){

			

			echo $val." ";
			
			

		}
		echo ">";
		
	}else{
		
		echo "</".$tag.">";
		
	}

}
function SingleTagShow($tag, ...$arg){


	echo "<".$tag." ";
	if(count($arg) > 0){

		foreach($arg as $val){

			echo $val." ";

		}

	}
	echo ">";

}
function form(...$arg)
{

	
	ContainerTagShow("form", ...$arg);

}
function p(...$arg)
{


	ContainerTagShow("p", ...$arg);
	

}
function select(...$arg)
{

	ContainerTagShow("select", ...$arg);

}
function option(...$arg)
{


	ContainerTagShow("option", ...$arg);

}
function input(...$arg)
{

	SingleTagShow("input", ...$arg);

}
function div(...$arg)
{

	ContainerTagShow("div", ...$arg);

}
function span(...$arg)
{

	ContainerTagShow("span", ...$arg);
}
function a(...$arg)
{

	ContainerTagShow("a", ...$arg);
}
function br(...$arg)
{

	SingleTagShow("br", ...$arg);
}
function img(...$arg)
{

	SingleTagShow("img", ...$arg);
}
function textarea(...$arg)
{


	ContainerTagShow("textarea", ...$arg);
}
function fieldset(...$arg)
{


	ContainerTagShow("fieldset", ...$arg);
}
function legend(...$arg)
{


	ContainerTagShow("legend", ...$arg);
}
function h1(...$arg)
{
	ContainerTagShow("h1", ...$arg);
}
function h2(...$arg)
{
	ContainerTagShow("h2", ...$arg);
}
function label(...$arg)
{
	ContainerTagShow("label", ...$arg);
}
function video(...$arg)
{
	ContainerTagShow("video", ...$arg);
}
function source(...$arg)
{
	SingleTagShow("source", ...$arg);
}
function button(...$arg)
{
	ContainerTagShow("button", ...$arg);
}
function strike(...$arg)
{
	ContainerTagShow("strike", ...$arg);
}
function table(...$arg)
{
	ContainerTagShow("table", ...$arg);
}
function tr(...$arg)
{
	ContainerTagShow("tr", ...$arg);
}
function td(...$arg)
{
	ContainerTagShow("td", ...$arg);
}
function th(...$arg)
{
	ContainerTagShow("th", ...$arg);
}
?>