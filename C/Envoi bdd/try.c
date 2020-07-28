#include <stdio.h>
#include <stdlib.h>
#include <limits.h>
#include <mysql/mysql.h>
#include <unistd.h>

#define MAX_LEN     500
void finish_with_error(MYSQL *);


int main(int argc, char *argv[])
{
    if (fopen("essai.png","r")!=NULL){
        FILE * f = popen("zbarimg essai.png", "r");

        char try[MAX_LEN] = {0};
        fgets(try, MAX_LEN, f);

        for(int i = 0; i < MAX_LEN - 10 ; i++){
            try[i] =try[i+8];
        }
         printf("%s\n", try);
        pclose(f);


        MYSQL *con = mysql_init(NULL);
        if(con == NULL)
        {
            fprintf(stderr,"%s\n",mysql_error(con));
        }

        /*
        IMPORTANT : Remplacer ici les valeurs pour correspondre à la base de données correpondante.
                    Ce fichier est sur le serveur, par conséquent les informations de compte et de mot de passe ne peuvent pas 
                    être marqué ici. 
                    Vous devez donc l'adapter à vos propre besoin. En bas local avec un pack LAMPP par exemple.
        if(mysql_real_connect(con,"localhost","UTILISATEUR_BDD_ICI","MOT_DE_PASSE_ICI","NOM_DE_LA_BDD_ICI",0,NULL,0)==NULL)
        {
            finish_with_error(con);
        }
        */

        if(mysql_query(con,try))
        {
            finish_with_error(con);
        }

         mysql_close(con);
        if (rename("essai.png", "essai.old.png") != 0)
        {
            printf("Unable to rename files. Please check files exist and you have permissions to modify files.\n");
        }

         return  0;
     }
}
void finish_with_error(MYSQL * con)
{
fprintf (stderr, "%s\n", mysql_error (con));
mysql_close (con);
exit(1);
}