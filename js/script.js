class Voiture{

    //propriété d'instance
    marque;
    modele;
    annee;

    //propriété statique
    static ROUES = 4;
    
//propriété de j'sais plus 
constructor(marque, modele, annee){
    this.marque = marque;
    this.modele = modele;
    this.annee = annee;
}
}
const Voiture1 = new Voiture("Renault", 'Clio', 2020);

console.log(Voiture1);

