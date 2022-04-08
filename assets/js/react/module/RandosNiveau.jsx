import React, {useEffect, useState} from "react";

export default function RandosNiveau(props) {
    let [hikes, setHikes] = useState([]);
    let [ajaxTimeOut, setAjaxTimeOut] = useState(0);

    let listHikes = async () => {
        if (!ajaxTimeOut) {
            setAjaxTimeOut(1);

            let response = await fetch("/randonneeFetchRender");
            if (response.ok) {
                // console.log(await response.json())
                let dataSetHike = await response.json();
                setHikes(dataSetHike);

            } else {
                setHikes(response.status);
            }
        }
    }
    useEffect(listHikes)

    return <>
        {hikes.length && hikes.map((hike) => {
            if(props.level === hike.difficulty.level) {
                return <div key={hike.id} className="rando_ flex"/*{hike.id} "flex"*/>
                <img src='./img/moureze2.png' className="images zoom" alt="description"/>
                <div className="description">
                    <h2>{hike.name}</h2>
                    <p>Niveau: {hike.difficulty.level} </p>
                    <p>Durée: {hike.duration} heure(s)</p>
                    <p>Longueur : {hike.length} km</p>
                    <p>Description: {hike.Content} Sin autem ad adulescentiam perduxissent, dirimi tamen interdum
                        contentione vel
                        uxoriae condicionis vel commodi alicuius, quod idem adipisci uterque non posset... </p>
                    <a href={hike.nameSlugger} className="voir_plus">Voir plus</a>
                </div>
            </div>
            }
        }
        )
        }
    </>
}
