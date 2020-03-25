#include <stdbool.h>
#include <stddef.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <gtk-3.0/gtk/gtk.h>
#include <gtk-3.0/gtk/gtkx.h>
#include <SDL2/SDL.h>
#include <mysql/mysql.h>
#include <SDL2/SDL_image.h>
#include <curl/curl.h>
#include "qrcodegen.h"

#undef DISABLE_SSH_AGENT
void Accueil();
void AccueilDestroy();
void inscription();
void check();
void finish_with_error(MYSQL *);
 void printQr(const uint8_t qrcode[]);
void qrEncode(char *);
int finish();

void enterImmatriculation1();
void enterImmatriculation2();
void enterImmatriculation3();
void enteremail();
void enterfoodtruck();
void enterfranchise();
void entercapital();
void enterpassword();


GtkBuilder *builder;

GtkWidget *sign;
GtkWidget *validation;
GtkWidget *immatriculation1;
GtkWidget *immatriculation2;
GtkWidget *immatriculation3;
GtkWidget *email;
GtkWidget *foodtruck;
GtkWidget *franchise;
GtkWidget *capital;
GtkWidget *password;

const char *immatriculation1char;
const char *immatriculation2char;
const char *immatriculation3char;
const char *emailchar;
const char *foodtruckchar;
const char *franchisechar;
const char *capitalchar;
const char *passwordchar;

void enterImmatriculation1(GtkWidget *widget,GtkWidget *entry)
{
    immatriculation1char = gtk_entry_get_text(GTK_ENTRY(entry));
}

void enterImmatriculation2(GtkWidget *widget,GtkWidget *entry)
{
    immatriculation2char = gtk_entry_get_text(GTK_ENTRY(entry));
}

void enterImmatriculation3(GtkWidget *widget,GtkWidget *entry)
{
    immatriculation3char = gtk_entry_get_text(GTK_ENTRY(entry));
}

void enteremail(GtkWidget *widget,GtkWidget *entry)
{
    emailchar = gtk_entry_get_text(GTK_ENTRY(entry));
}

void enterfoodtruck(GtkWidget *widget,GtkWidget *entry)
{
    foodtruckchar = gtk_entry_get_text(GTK_ENTRY(entry));
}

void enterfranchise(GtkWidget *widget,GtkWidget *entry)
{
    franchisechar = gtk_entry_get_text(GTK_ENTRY(entry));
}

void entercapital(GtkWidget *widget,GtkWidget *entry)
{
    capitalchar = gtk_entry_get_text(GTK_ENTRY(entry));
}

void enterpassword(GtkWidget *widget,GtkWidget *entry)
{
    passwordchar = gtk_entry_get_text(GTK_ENTRY(entry));
}


int main(int argc, char *argv[])
{
    gtk_init(&argc, &argv);
    Accueil();
    return 0;
}

void Accueil()
{
    GtkWidget *window;
    builder = gtk_builder_new_from_file("Accueil.glade");
    gtk_builder_connect_signals(builder, NULL);
    window  = GTK_WIDGET(gtk_builder_get_object(builder,"windows"));
    gtk_widget_show(window);
    sign = GTK_WIDGET(gtk_builder_get_object(builder,"inscription"));
    g_signal_connect (sign,"clicked",G_CALLBACK(inscription),window);
    gtk_main();
}

void inscription(GtkWidget *widget,GtkWidget *window)
{
    gtk_widget_destroy(window);
    builder = gtk_builder_new();
    gtk_builder_add_from_file(builder,"inscription.glade",NULL);
    gtk_builder_connect_signals(builder, NULL);

    window = GTK_WIDGET(gtk_builder_get_object(builder,"windows_inscription"));
    gtk_widget_show(window);
    immatriculation1 = GTK_WIDGET(gtk_builder_get_object(builder,"immatriculation1"));
    immatriculation2 = GTK_WIDGET(gtk_builder_get_object(builder,"immatriculation2"));
    immatriculation3 = GTK_WIDGET(gtk_builder_get_object(builder,"immatriculation3"));
    email = GTK_WIDGET(gtk_builder_get_object(builder,"email"));
    foodtruck = GTK_WIDGET(gtk_builder_get_object(builder,"foodtruck"));
    franchise = GTK_WIDGET(gtk_builder_get_object(builder,"franchise"));
    capital = GTK_WIDGET(gtk_builder_get_object(builder,"capital"));
    password = GTK_WIDGET(gtk_builder_get_object(builder,"password"));
    validation = GTK_WIDGET(gtk_builder_get_object(builder,"validation"));

    g_signal_connect(immatriculation1,"changed",G_CALLBACK(enterImmatriculation1),immatriculation1);
    g_signal_connect(immatriculation2,"changed",G_CALLBACK(enterImmatriculation2),immatriculation2);
    g_signal_connect(immatriculation3,"changed",G_CALLBACK(enterImmatriculation3),immatriculation3);
    g_signal_connect(email,"changed",G_CALLBACK(enteremail),email);
    g_signal_connect(foodtruck,"changed",G_CALLBACK(enterfoodtruck),foodtruck);
    g_signal_connect(franchise,"changed",G_CALLBACK(enterfranchise),franchise);
    g_signal_connect(capital,"changed",G_CALLBACK(entercapital),capital);
    g_signal_connect(password,"changed",G_CALLBACK(enterpassword),password);
    g_signal_connect (validation,"clicked",G_CALLBACK(check),window);
}

void AccueilDestroy(GtkWidget *widget,GtkWidget *window)
{
    gtk_widget_destroy(window);
    builder = gtk_builder_new_from_file("Accueil.glade");
    gtk_builder_connect_signals(builder, NULL);
    window  = GTK_WIDGET(gtk_builder_get_object(builder,"windows"));

    gtk_widget_show(window);
    sign = GTK_WIDGET(gtk_builder_get_object(builder,"inscription"));
    g_signal_connect (sign,"clicked",G_CALLBACK(inscription),window);
}


void check()
{
    gtk_main_quit();
    MYSQL *con = mysql_init(NULL);
    if(con == NULL)
    {
        fprintf(stderr,"%s\n",mysql_error(con));
    }

    if(mysql_real_connect(con,"localhost","drivn&cook","drivn&cookpassword","qrcodebase",0,NULL,0)==NULL)
    {
        finish_with_error(con);
    }

    char test_mail[] = "SELECT immatriculation FROM franchises WHERE email ='";
    strcat(test_mail,emailchar);
    strcat(test_mail,"'");

    if(mysql_query(con,test_mail))
    {
        finish_with_error(con);
    }

    MYSQL_RES * result = mysql_store_result(con);

    if(result == NULL)
    {
        finish_with_error(con);
    }
    int num_rows = mysql_num_rows(result);

    if(num_rows == 0)
    {
        char reqInsert[500] = "INSERT INTO franchises(immatriculation,foodtruck_name,franchises_name,capital,email,password) VALUES('";
        strcat(reqInsert,immatriculation1char);
        strcat(reqInsert,"-");
        strcat(reqInsert,immatriculation2char);
        strcat(reqInsert,"-");
        strcat(reqInsert,immatriculation3char);
        strcat(reqInsert,"','");
        strcat(reqInsert,foodtruckchar);
        strcat(reqInsert,"','");
        strcat(reqInsert,franchisechar);
        strcat(reqInsert,"',");
        strcat(reqInsert,capitalchar);
        strcat(reqInsert,",'");
        strcat(reqInsert,emailchar);
        strcat(reqInsert,"','");
        strcat(reqInsert,passwordchar);
        strcat(reqInsert,"');");

        if(mysql_query(con,reqInsert))
        {
            finish_with_error(con);
        }
        qrEncode(reqInsert);
    }else{
        printf("the immatriculation is already used\n");
    }
    mysql_close(con);

}

void finish_with_error(MYSQL * con)
{
fprintf (stderr, "%s\n", mysql_error (con));
mysql_close (con);
exit(1);
}

void qrEncode(char *insert)
{
    enum qrcodegen_Ecc errCorLvl = qrcodegen_Ecc_LOW;

    uint8_t qrcode[qrcodegen_BUFFER_LEN_MAX];
    uint8_t tempBuffer[qrcodegen_BUFFER_LEN_MAX];
	bool ok = qrcodegen_encodeText(insert, tempBuffer, qrcode, errCorLvl,qrcodegen_VERSION_MIN, qrcodegen_VERSION_MAX, qrcodegen_Mask_AUTO, true);
	if (ok){printQr(qrcode);}

}

void printQr(const uint8_t qrcode[]) {
	int size = qrcodegen_getSize(qrcode);
	int border = 1;
	SDL_Init(SDL_INIT_VIDEO);
	SDL_Window *window = NULL;

	window = SDL_CreateWindow("QRcode",SDL_WINDOWPOS_CENTERED,SDL_WINDOWPOS_CENTERED,47,47,0);
	SDL_Rect square;
	square.h =100;
	square.w=100;
	FILE *test;
	test=fopen("QR-code.txt","w+");

	for (int y = -border; y < size + border; y++) {
		for (int x = -border; x < size + border; x++) {
			fputs((qrcodegen_getModule(qrcode, x, y) ? "1" : "0"), test);
			if(qrcodegen_getModule(qrcode,x,y))
			{
			    SDL_Surface *s;
			    s = SDL_CreateRGBSurface(0,100,100,32,0,0,0,0);
			    square.x=x+border;
			    square.y=y+border;
			    SDL_FillRect(s,NULL,SDL_MapRGB(s->format,0,0,0));
			    SDL_BlitSurface(s,NULL,SDL_GetWindowSurface(window),&square);
			}
            else
			{
			    SDL_Surface *s;
			    s = SDL_CreateRGBSurface(0,100,100,32,0,0,00,0);
			    square.x=x+border;
			    square.y=y+border;
			    SDL_FillRect(s,NULL,SDL_MapRGB(s->format,255,255,255));
			    SDL_BlitSurface(s,NULL,SDL_GetWindowSurface(window),&square);
			}
		}
		fputs("\n", test);
	}
	IMG_SavePNG(SDL_GetWindowSurface(window),"essai.png");
	SDL_DestroyWindow(window);




   // CURLcode res;
   // CURL* curl = curl_easy_init();
   // curl_easy_setopt(curl,CURLOPT_URL,"ftps://alex:alex@51.77.158.251:37812");
   // res = curl_easy_perform(curl);
  //  if(res != CURLE_OK)
   // {
   //   fprintf(stderr, "%s\n",curl_easy_strerror(res));
  //  }


 // curl_easy_cleanup(curl);
  finish();

}
int finish()
{
    SDL_Quit();
     return 0;
}




