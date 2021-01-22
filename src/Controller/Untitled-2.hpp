#ifndef JEUBATAILLE_HPP
#define JEUBATAILLE_HPP
#include "Joueur.hpp"
#include "Paquet.hpp"
#include "Utility.hpp"
#include <cstdlib>

enum class cartes : char {DEPUT,deux,trois,quatre,cinq,sixe,sept,huit,neuf,dix,VALET,DAME,ROI,AS,END};
cartes& operator ++ (cartes& e)
{
    if (e == cartes::END) {
        throw std::out_of_range("Impossible ");
    }
    e = cartes(static_cast<std::underlying_type<cartes>::type>(e) + 1);
    return e;
}


enum class couleurs : char {DEPUT,carreau,pique,trifle,coeur,END};
couleurs& operator ++ (couleurs& e)
{
    if (e == couleurs::END) {
        throw std::out_of_range(" Impossible ");
    }
    e = couleurs(static_cast<std::underlying_type<couleurs>::type>(e) + 1);
    return e;
}


class JeuBataille
{
        private:
        int nbCarte;
        int nbJoueur;
        Joueur<cartes,couleurs> j1{};
        Joueur<cartes,couleurs>  j2{};
        Paquet<cartes,couleurs>  p{};
    public:
        JeuBataille(){}

        void lauchGame()
        {


            p.melanger();

            p.split(j1.gethand(),j2.gethand(),(p.getSize()/2));//26 c'est le nombre carte que chaque jour va prendre
            /*std::cout <<"presentation Joueur 1 a ces different"<<endl;
            std::cout << "Joueur 1 a "<<endl;
            affiche(j1);
            std::cout <<endl;
            std::cout << "Joueur 2 a "<<endl;
            affiche(j2);*/
            //system("cls");
            Utility::clearConsole();
            cout << "\n\n .......................................jeu commence ................................ " << endl;
            system("pause");
             //Utility::pauseWaitPressEnter;
            cout <<endl;
            do{
               cout << "\14 Joueur1 a Bose  la carte " << JeuBataille::magic1(j1.gethand().listPaquet.back().getNom() )<< endl;
               cout << "\17 Joueur2 a Bose  la carte " <<  JeuBataille::magic1(j2.gethand().listPaquet.back().getNom())<< endl;
                    vector<Carte<cartes,couleurs>> v1;
                    joue(v1);
                    v1.clear();
               cout <<endl;
               //system("pause");
               Utility::pauseWaitPressEnter();
               cout << "\n"<<endl;
            }while(j1.gethand().listPaquet.size() !=0 || j1.gethand().listPaquet.size() );

            std::cout <<"\n\n+++++++++++++++++++++++++++++++++Fin de jeu Bataille++++++++++++++++++++++++++++++++++"<<endl;
             //system("pause");
             Utility::pauseWaitPressEnter();
             system("cls");
            std::cout <<"---------------------------------------Resulta du jeu ------------------------------------"<<endl;
            std::cout <<"\n Joueur 1 a eu "<<j1.getscore().ComptePuissance()<<" Score"<<endl;
            std::cout <<" Joueur 2 a eu "<<j2.getscore().ComptePuissance()<<" Score"<<endl;
            if(j1.getscore().ComptePuissance()> j2.getscore().ComptePuissance())
                std::cout <<"\n\n  Et bien C'est Joureur 1 qui a gagnie Filicitation \14 \14 \14"<<endl;
            else
                std::cout <<"\n\n  Et bien C'est Joureur 2 qui a gagnie Filicitation \14 \14 \14"<<endl;

            //system("pause");
            Utility::pauseWaitPressEnter();

            system("cls");

        }



        void joue(vector<Carte<cartes,couleurs>> v1){



                            if(j1.gethand().listPaquet.back().getNom()  > j2.gethand().listPaquet.back().getNom())
                            {


                                //v1.push_back(j1.gethand().listPaquet.back());
                                v1.push_back(j2.gethand().listPaquet.back());



                                //j1.gethand().listPaquet.pop_back();
                                j2.gethand().listPaquet.pop_back();

                                j1.getscore().setList(v1);

                                cout << "\n \20 C'est joeur 1 qui a prie le "<<v1.size()+1 <<" carte" <<endl;

                            }
                            else if(j1.gethand().listPaquet.back().getNom()  < j2.gethand().listPaquet.back().getNom())
                            {

                                v1.push_back(j1.gethand().listPaquet.back());
                                //v1.push_back(j2.gethand().listPaquet.back());



                                j1.gethand().listPaquet.pop_back();
                                //j2.gethand().listPaquet.pop_back();
                                 j2.getscore().setList(v1);

                                cout << "\n \20 C'est jooeur 2 qui a prie le "<<v1.size()+1 <<" carte" <<endl;
                            }
                            else
                            {
                                 cout << "\n \20 le deux carte pose sont egaux donc deux autre carte doit etre pose par chaque joueur et on va regrade le dernier"<<endl;
                                   //les carte egaux
                                   v1.push_back(j1.gethand().listPaquet.back());
                                   v1.push_back(j2.gethand().listPaquet.back());
                                   j1.gethand().listPaquet.pop_back();
                                   j2.gethand().listPaquet.pop_back();
                                   // les 1 de deux autre doit etre pose
                                   if(!j1.gethand().listPaquet.empty() || !j2.gethand().listPaquet.empty())
                                   {
                                       v1.push_back(j1.gethand().listPaquet.back());
                                       v1.push_back(j2.gethand().listPaquet.back());
                                       j1.gethand().listPaquet.pop_back();
                                       j2.gethand().listPaquet.pop_back();
                                   }


                                   // le 2 de deux autre carte doit etre pose;
                                   joue(v1);


                            }


        }




        virtual ~JeuBataille()
        {

        }
        void affiche( Joueur<cartes,couleurs> &j){

                std::cout << "-----------------------------------------------------------"<< endl;
                for(int i=0;i<j.gethand().listPaquet.size();i++)
                {
                   std::cout<< "| " <<JeuBataille::magic1(j.gethand().listPaquet[i].getNom())<< " " << JeuBataille::magic2(j.gethand().listPaquet[i].getCouleur());

                }
                std::cout <<endl;
        }



        static const char* magic1 (cartes e){



                             const std::map<cartes,const char*> MyEnumStrings {
                        { cartes::DEPUT, "DEPUT" },
                        { cartes::deux, "2" },
                        { cartes::trois, "3" },
                        { cartes::quatre, "4" },
                        { cartes::cinq, "5" },
                        { cartes::sixe, "6" },
                        { cartes::sept, "7" },
                        { cartes::huit, "8" },
                        { cartes::neuf, "9" },
                        { cartes::dix, "10" },
                        { cartes::VALET, "VALET" },
                        { cartes::DAME, "DAME" },
                        { cartes::ROI, "ROI" },
                        { cartes::AS, "AS" },


                    };
                    auto   it  = MyEnumStrings.find(e);
                    return it == MyEnumStrings.end() ? "ICONNUCARTE" : it->second;


        }

        static const char* magic2 (couleurs e)
        {
                    const std::map<couleurs,const char*> MyEnumStrings {
                { couleurs::DEPUT, "DEPUT" },
                { couleurs::carreau, "carreau" },
                { couleurs::pique, "pique" },
                { couleurs::trifle, "trifle" },
                { couleurs::coeur, "coeur" }


            };
            auto   it  = MyEnumStrings.find(e);
            return it == MyEnumStrings.end() ? "INCONNUFAMILLE" : it->second;
        }
    protected:


};

#endif // JEUBATAILLE_HPP
