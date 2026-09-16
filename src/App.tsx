import './App.css';
import {
  useQuery,
  useQueryClient,
} from '@tanstack/react-query';
import { useState } from 'react';

export function App({predata}){
    const [inputs,setInputs] = useState(predata);
    const [content,setContent] = useState(<ContentView target={inputs}/>);

    return(
    <><div><p>Фильтры<button onClick={()=>{setInputs(predata);setContent(<ContentView target={predata}/>);}}>Сброс</button></p><span>Название</span>
    <input value={inputs[0]} onChange={e=>{setInputs([e.target.value,inputs[1],inputs[2]])}}/>
    <span>Тип</span>
    <input value={inputs[1]} onChange={e=>{setInputs([inputs[0],e.target.value,inputs[2]])}}/>
    <span>Страница</span>
    <input type="number" min="0" value={inputs[2]} onChange={e=>{setInputs([inputs[0],inputs[1],e.target.value])}}/>
    <button onClick={()=>{setContent(<ContentView target={inputs}/>);}}>Применить</button>
    </div>{content}</>
  );
}

function ContentView({target}){
    var requestid = ""+target[0]+target[1]+target[2];
  
  const { isPending, error, data } = useQuery({
    queryKey: [requestid],
    queryFn: () =>
      $.ajax({
      url: "http://localhost:1111/webparse.php?"+
        (target[0]?"match="+target[0]+"&":"")+(target[1]?"type="+target[1]+"&":"")+(target[2]?"page="+target[2]+"&":"")+"callback=handleData",
      dataType: "jsonp",
      jsonp: "callback",
    })
  });
  if (isPending) return 'Loading...'

  if (error) return 'An error has occurred: ' + error.message
  return (<>
      {/* {!item ? (<button onClick={()=>{setItem(true)}}>Вывести случайный товар</button>):(<ItemDetails />)} */}
    {data.map(x=>(<details key={x.id}><summary>{x.title}</summary>
    <p>id: {x.id}</p>
    <p>price: {x.priceFormatted}</p>
    <p>currency: {x.currency}</p>
    <p>brand: {x.brand}</p>
    <p>rating: {x.rating}</p>
    <p>review count: {x.reviewsQuantity}</p>
    <p>More info: <a href={'https://kaspi.kz/shop'+ x.shopLink}>{'https://kaspi.kz/shop'+ x.shopLink}</a></p>
  </details>))}</>
  );
}

function ItemDetails(){
  const { isPending, error, data } = useQuery({
    queryKey: ['item_request'],
    queryFn: () =>
      $.ajax({
      url: "http://localhost:1111/getitem.php?callback=handleData",
      dataType: "jsonp",
      jsonp: "callback",
    })
  });
  if (isPending) return 'Loading...'
  if (error) return 'An error has occurred: ' + error.message

  return(<>
  <ul><li>{data.title}</li><li>{data.info}</li>
  <li>{Object.keys(data.details).map(x=><div>{x+':'+data.details[x]}</div>)}</li></ul></>);
}