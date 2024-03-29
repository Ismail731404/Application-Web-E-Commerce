<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Pays', ChoiceType::class, [
                'choices' => [  
                'Afghanistan'	=>'Afghanistan',
                'Afrique du Sud'	=>'Afrique du Sud',
                'Albanie'	=>'Albanie',
                'Algérie'	=>'Algérie',
                'Allemagne'	=>'Allemagne',
                'Andorre'	=>'Andorre',
                'Angola'	=>'Angola',
                'Anguilla'	=>'Anguilla',
                'Antarctique-Casey'	=>'Antarctique-Casey',
                'Antarctique-Scott'	=>'Antarctique-Scott',
                'Antigua et Barbuda '	=>'Antigua et Barbuda ',
                'Antigua-et-Barbuda'	=>'Antigua-et-Barbuda',
                'Antilles Françaises'	=>'Antilles Françaises',
                'Antilles hollandaise'	=>'Antilles hollandaise',
                'Arabie saoudite'	=>'Arabie saoudite',
                'Argentine'	=>'Argentine',
                'Arménie'	=>'Arménie',
                'Aruba'	=>'Aruba',
                'Ascension'	=>'Ascension',
                'Atlantique Est'	=>'Atlantique Est',
                'Atlantique Ouest'	=>'Atlantique Ouest',
                'Australie'	=>'Australie',
                'Autriche'	=>'Autriche',
                'Azerbaïdjan'	=>'Azerbaïdjan',
                'Bahamas'	=>'Bahamas',
                'Bahreïn'	=>'Bahreïn',
                'Bangladesh'	=>'Bangladesh',
                'Barbade'	=>'Barbade',
                'Belgique'	=>'Belgique',
                'Belize'	=>'Belize',
                'Bermudes'	=>'Bermudes',
                'Bhoutan'	=>'Bhoutan',
                'Biélorussie'	=>'Biélorussie',
                'Bolivie'	=>'Bolivie',
                'Bosnie-Herzégovine'	=>'Bosnie-Herzégovine',
                'Botswana'	=>'Botswana',
                'Brunei Darussalam'	=>'Brunei Darussalam',
                'Brésil'	=>'Brésil',
                'Bulgarie'	=>'Bulgarie',
                'Burkina Faso'	=>'Burkina Faso',
                'Burundi'	=>'Burundi',
                'Bénin'	=>'Bénin',
                'Cambodge'	=>'Cambodge',
                'Cameroun'	=>'Cameroun',
                'Canada'	=>'Canada',
                'Cap-Vert'	=>'Cap-Vert',
                'Cayman (Iles)'	=>'Cayman (Iles)',
                'Chili'	=>'Chili',
                'Chine'	=>'Chine',
                'Chypre'	=>'Chypre',
                'Colombie'	=>'Colombie',
                'Congo'	=>'Congo',
                'Congo Zaïre (Rep. Dem.)'	=>'Congo Zaïre (Rep. Dem.)',
                'Corée du Nord'	=>'Corée du Nord',
                'Corée du Sud'	=>'Corée du Sud',
                'Costa Rica'	=>'Costa Rica',
                'Croatie'	=>'Croatie',
                'Cuba'	=>'Cuba',
                'Côte d\'Ivoire'	=>'Côte d\'Ivoire',
                'Danemark'	=>'Danemark',
                'Djibouti'	=>'Djibouti',
                'Dominicaine (Rep.)'	=>'Dominicaine (Rep.)',
                'Dominique'	=>'Dominique',
                'Egypte'	=>'Egypte',
                'Emirats arabes unis'	=>'Emirats arabes unis',
                'Equateur'	=>'Equateur',
                'Erythrée'	=>'Erythrée',
                'Espagne'	=>'Espagne',
                'Estonie'	=>'Estonie',
                'Etats Unis d\'Amérique '	=>'Etats Unis d\'Amérique ',
                'Ethiopie'	=>'Ethiopie',
                'Fidji'	=>'Fidji',
                'Finlande'	=>'Finlande',
                'France'	=>'France',
                'Fédération russe'	=>'Fédération russe',
                'Gabon'	=>'Gabon',
                'Gambie'	=>'Gambie',
                'Ghana'	=>'Ghana',
                'Gibraltar'	=>'Gibraltar',
                'Grenade'	=>'Grenade',
                'Groà«nland'	=>'Groà«nland',
                'Grèce'	=>'Grèce',
                'Guadeloupe'	=>'Guadeloupe',
                'Guam'	=>'Guam',
                'Guatemala'	=>'Guatemala',
                'Guinée'	=>'Guinée',
                'Guinée Française'	=>'Guinée Française',
                'Guinée équatoriale'	=>'Guinée équatoriale',
                'Guinée-Bissao'	=>'Guinée-Bissao',
                'Guyane'	=>'Guyane',
                'Géorgie'	=>'Géorgie',
                'Hawaï'	=>'Hawaï',
                'Haïti'	=>'Haïti',
                'Honduras'	=>'Honduras',
                'Hong Kong'	=>'Hong Kong',
                'Hongrie'	=>'Hongrie',
                'Ile Christmas'	=>'Ile Christmas',
                'Ile Feroe'	=>'Ile Feroe',
                'Ile de Norfolk'	=>'Ile de Norfolk',
                'Iles Caïmans'	=>'Iles Caïmans',
                'Iles Cook'	=>'Iles Cook',
                'Iles Falklands'	=>'Iles Falklands',
                'Iles Salomon'	=>'Iles Salomon',
                'Iles vierges américaines'	=>'Iles vierges américaines',
                'Inde'	=>'Inde',
                'Indonésie'	=>'Indonésie',
                'Iran'	=>'Iran',
                'Iraq'	=>'Iraq',
                'Irlande'	=>'Irlande',
                'Islande'	=>'Islande',
                'Israà«l'	=>'Israà«l',
                'Italie'	=>'Italie',
                'Jamaïque'	=>'Jamaïque',
                'Japon'	=>'Japon',
                'Jordanie'	=>'Jordanie',
                'Kazakhstan'	=>'Kazakhstan',
                'Kenya'	=>'Kenya',
                'Kirghizistan'	=>'Kirghizistan',
                'Kiribati'	=>'Kiribati',
                'Koweït'	=>'Koweït',
                'Laos'	=>'Laos',
                'Lesotho'	=>'Lesotho',
                'Lettonie'	=>'Lettonie',
                'Liban'	=>'Liban',
                'Libye'	=>'Libye',
                'Libéria'	=>'Libéria',
                'Liechtenstein'	=>'Liechtenstein',
                'Lituanie'	=>'Lituanie',
                'Luxembourg'	=>'Luxembourg',
                'Macao'	=>'Macao',
                'Macédoine'	=>'Macédoine',
                'Madagascar'	=>'Madagascar',
                'Malaisie'	=>'Malaisie',
                'Malawi'	=>'Malawi',
                'Maldives'	=>'Maldives',
                'Mali'	=>'Mali',
                'Malte'	=>'Malte',
                'Marisat (Atlantique Est)'	=>'Marisat (Atlantique Est)',
                'Marisat (Atlantique Ouest)'	=>'Marisat (Atlantique Ouest)',
                'Maroc'	=>'Maroc',
                'Marshall'	=>'Marshall',
                'Maurice'	=>'Maurice',
                'Mauritanie'	=>'Mauritanie',
                'Mayotte'	=>'Mayotte',
                'Mexique Centre'	=>'Mexique Centre',
                'Micronésie'	=>'Micronésie',
                'Moldavie'	=>'Moldavie',
                'Monaco'	=>'Monaco',
                'Mongolie'	=>'Mongolie',
                'Monteserrat'	=>'Monteserrat',
                'Montserrat'	=>'Montserrat',
                'Mozambique'	=>'Mozambique',
                'Namibie'	=>'Namibie',
                'Nauru'	=>'Nauru',
                'Nicaragua'	=>'Nicaragua',
                'Niger'	=>'Niger',
                'Nigeria'	=>'Nigeria',
                'Niue'	=>'Niue',
                'Norfolk (Ile)'	=>'Norfolk (Ile)',
                'Norvège'	=>'Norvège',
                'Nouvelle-Calédonie'	=>'Nouvelle-Calédonie',
                'Nouvelle-Zélande'	=>'Nouvelle-Zélande',
                'Népal'	=>'Népal',
                'Oman'	=>'Oman',
                'Ouganda'	=>'Ouganda',
                'Ouzbekistan'	=>'Ouzbekistan',
                'Pakistan'	=>'Pakistan',
                'Palau'	=>'Palau',
                'Palestine'	=>'Palestine',
                'Panama'	=>'Panama',
                'Papouasie - Nouvelle Guinée'	=>'Papouasie - Nouvelle Guinée',
                'Paraguay'	=>'Paraguay',
                'Pays-Bas'	=>'Pays-Bas',
                'Philippines'	=>'Philippines',
                'Pologne'	=>'Pologne',
                'Polynésie Française'	=>'Polynésie Française',
                'Porto Rico'	=>'Porto Rico',
                'Portugal'	=>'Portugal',
                'Pérou'	=>'Pérou',
                'Qatar'	=>'Qatar',
                'Roumanie'	=>'Roumanie',
                'Royaume-Uni'	=>'Royaume-Uni',
                'Rwanda'	=>'Rwanda',
                'République Centrafricaine'	=>'République Centrafricaine',
                'République Dominicaine'	=>'République Dominicaine',
                'République Tchèque'	=>'République Tchèque',
                'République comorienne'	=>'République comorienne',
                'République du Tchad'	=>'République du Tchad',
                'Réunion'	=>'Réunion',
                'Saint Eustache'	=>'Saint Eustache',
                'Saint Hélène'	=>'Saint Hélène',
                'Saint Martin'	=>'Saint Martin',
                'Saint-Christophe-et-Niévès'	=>'Saint-Christophe-et-Niévès',
                'Saint-Kitts-et-Nevis'	=>'Saint-Kitts-et-Nevis',
                'Saint-Marin'	=>'Saint-Marin',
                'Saint-Vincent-et-Grenadines'	=>'Saint-Vincent-et-Grenadines',
                'Saint-Vincent-et-les Grenadines'	=>'Saint-Vincent-et-les Grenadines',
                'Sainte-Lucie'	=>'Sainte-Lucie',
                'Saipan'	=>'Saipan',
                'Salvador'	=>'Salvador',
                'Samoa Américaines'	=>'Samoa Américaines',
                'Samoa occidentales'	=>'Samoa occidentales',
                'Sao Tomé-et-Principe'	=>'Sao Tomé-et-Principe',
                'Seychelles'	=>'Seychelles',
                'Sierra Leone'	=>'Sierra Leone',
                'Singapour'	=>'Singapour',
                'Slovaquie'	=>'Slovaquie',
                'Slovénie'	=>'Slovénie',
                'Somalie'	=>'Somalie',
                'Soudan'	=>'Soudan',
                'Sri Lanka'	=>'Sri Lanka',
                'Suisse'	=>'Suisse',
                'Suriname'	=>'Suriname',
                'Suède'	=>'Suède',
                'Swaziland'	=>'Swaziland',
                'Syrie'	=>'Syrie',
                'Sénégal'	=>'Sénégal',
                'Tadjikistan (Rep. du)'	=>'Tadjikistan (Rep. du)',
                'Taiwan'	=>'Taiwan',
                'Tanzanie'	=>'Tanzanie',
                'Thaïlande'	=>'Thaïlande',
                'Togo'	=>'Togo',
                'Tokelau'	=>'Tokelau',
                'Tonga'	=>'Tonga',
                'Trinité-et-Tobago'	=>'Trinité-et-Tobago',
                'Tunisie'	=>'Tunisie',
                'Turkménistan'	=>'Turkménistan',
                'Turks et Caïcos (Iles)'	=>'Turks et Caïcos (Iles)',
                'Turks et caicos'	=>'Turks et caicos',
                'Turquie'	=>'Turquie',
                'Tuvalu'	=>'Tuvalu',
                'Ukraine'	=>'Ukraine',
                'Union Birmane'	=>'Union Birmane',
                'Uruguay'	=>'Uruguay',
                'Vanuatu'	=>'Vanuatu',
                'Vatican'	=>'Vatican',
                'Vierges Américaines (Iles)'	=>'Vierges Américaines (Iles)',
                'Vierges Britanniques (Iles)'	=>'Vierges Britanniques (Iles)',
                'Viêt-Nam'	=>'Viêt-Nam',
                'Vénézuela'	=>'Vénézuela',
                'Wallis et Futuna'	=>'Wallis et Futuna',
                'Yougoslavie'	=>'Yougoslavie',
                'Yémen'	=>'Yémen',
                'Zambie'	=>'Zambie',
                'Zimbabwe'	=>'Zimbabwe'
                    
                ],
                'placeholder' => false

            ])
            ->add('Ville')
            ->add('Region')
            ->add('Code_Postal', NumberType::class)
            ->add('Boite_Postal')
            ->add('Rue')
            ->add(
                'Envoyer',
                SubmitType::class,
                [
                    'attr' => ['class' => 'btn btn-primary','title'=>'Enregistre les modification']
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
