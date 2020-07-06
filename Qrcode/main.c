#include <stdbool.h>
#include <stddef.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <memory.h>
#include <gtk-3.0/gtk/gtk.h>
#include <gtk-3.0/gtk/gtkx.h>
#include <SDL2/SDL.h>
#include <SDL2/SDL_image.h>
#include <curl/curl.h>
#include <sys/stat.h>
#include <errno.h>
#include <ctype.h>
#include "qrcodegen.h"
#include "sha256.h"


#define LOCAL_FILE      "/home/alex/Bureau/Qrcode/essai.png"

void Accueil();
void AccueilDestroy();
void inscription();
void check();
void printQr(const uint8_t qrcode[]);
void qrEncode(char *);
int transfert();


void enteremail();
void enterfirstname();
void enterlastname();
void enterphonenumber();
void enterpassword();


GtkBuilder *builder;

GtkWidget *sign;
GtkWidget *validation;
GtkWidget *email;
GtkWidget *firstname;
GtkWidget *lastname;
GtkWidget *phonenumber;
GtkWidget *password;

const char *emailchar;
const char *firstnamechar;
const char *lastnamechar;
const char *phonenumberchar;
const char *passwordchar;


void enteremail(GtkWidget *entry)
{
    emailchar = gtk_entry_get_text(GTK_ENTRY(entry));
}

void enterfirstname(GtkWidget *entry)
{
    firstnamechar = gtk_entry_get_text(GTK_ENTRY(entry));
}

void enterlastname(GtkWidget *entry)
{
    lastnamechar = gtk_entry_get_text(GTK_ENTRY(entry));
}

void enterphonenumber(GtkWidget *entry)
{
    phonenumberchar = gtk_entry_get_text(GTK_ENTRY(entry));
}

void enterpassword(GtkWidget *entry)
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
    email = GTK_WIDGET(gtk_builder_get_object(builder,"email"));
    firstname = GTK_WIDGET(gtk_builder_get_object(builder,"firstname"));
    lastname = GTK_WIDGET(gtk_builder_get_object(builder,"lastname"));
    phonenumber = GTK_WIDGET(gtk_builder_get_object(builder,"phone"));
    password = GTK_WIDGET(gtk_builder_get_object(builder,"password"));
    validation = GTK_WIDGET(gtk_builder_get_object(builder,"validation"));

    g_signal_connect(email,"changed",G_CALLBACK(enteremail),email);
    g_signal_connect(firstname,"changed",G_CALLBACK(enterfirstname),firstname);
    g_signal_connect(lastname,"changed",G_CALLBACK(enterlastname),lastname);
    g_signal_connect(phonenumber,"changed",G_CALLBACK(enterphonenumber),phonenumber);
    g_signal_connect(password,"changed",G_CALLBACK(enterpassword),password);
    g_signal_connect (validation,"clicked",G_CALLBACK(check),window);
}

void AccueilDestroy(GtkWidget *widget,GtkWidget *window)
{
    
    builder = gtk_builder_new_from_file("Accueil.glade");
    gtk_builder_connect_signals(builder, NULL);
    window  = GTK_WIDGET(gtk_builder_get_object(builder,"windows"));

    gtk_widget_show(window);
    sign = GTK_WIDGET(gtk_builder_get_object(builder,"inscription"));
    g_signal_connect (sign,"clicked",G_CALLBACK(inscription),window);
}


void check(GtkWidget *widget,GtkWidget *window)
{

    const char *verif;
    unsigned int i;
    char verif_email_one ='@';
    char verif_email_two ='.';
    bool access_email_one = FALSE;
    bool access_email_two = FALSE;
    bool access_phonenumber = TRUE;
    size_t size_email,size_firstname,size_lastname,size_phonenumber,size_password;

    size_phonenumber = strlen(phonenumberchar);
    size_email = strlen(emailchar);
    size_firstname = strlen(firstnamechar);
    size_lastname = strlen(lastnamechar);
   size_password = strlen(passwordchar);

    verif = emailchar;
    while((verif= strchr(verif,verif_email_one))!=NULL){
        ++verif;
        access_email_one = TRUE;
    }
    verif = emailchar;
    while((verif= strchr(verif,verif_email_two))!=NULL){
        ++verif;
        access_email_two = TRUE;
    }

    for( i=0; i<size_phonenumber; i++ ) {
        if(!isdigit(phonenumberchar[i]))
        {
            access_phonenumber = FALSE;
            printf("%d",phonenumberchar[i]);
            break;
        }
    }
    if(access_email_one && access_email_two && access_phonenumber && (size_email <=200)&& (size_firstname <=50)&& (size_lastname <=50) &&(size_password>=6)&&(size_password<=100)&&(size_phonenumber==10))
    {

        BYTE encode[SHA256_BLOCK_SIZE] ;
        SHA256_CTX ctx;
        sha256_init(&ctx);
        sha256_update(&ctx,(BYTE*)passwordchar, size_password);
        sha256_final(&ctx,encode);

        char reqInsert[2000] = "INSERT INTO franchise(email,role_id,first_name,last_name,phone_number,password) VALUES(";
        strcat(reqInsert,"'");
        strcat(reqInsert,emailchar);
        strcat(reqInsert,"',");
        strcat(reqInsert,"2");
        strcat(reqInsert,",'");
        strcat(reqInsert,firstnamechar);
        strcat(reqInsert,"','");
        strcat(reqInsert,lastnamechar);
        strcat(reqInsert,"','");
        strcat(reqInsert,phonenumberchar);
        strcat(reqInsert,"','");
         for (int i = 0; i < SHA256_BLOCK_SIZE; i++)
    {
         char hexa[3];
         sprintf(hexa, "%x", encode[i]);
         strcat(reqInsert, hexa);
    }
       // strcat(reqInsert,"PassToChange");
        strcat(reqInsert,"');");

        qrEncode(reqInsert);
        gtk_widget_destroy(window);

    }
    else{
        inscription(widget,window);
    }
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

	window = SDL_CreateWindow("QRcode",SDL_WINDOWPOS_CENTERED,SDL_WINDOWPOS_CENTERED,60,60,0);
	SDL_Rect square;
	square.h =300;
	square.w=300;
	FILE *test;
	test=fopen("QR-code.txt","w+");

	for (int y = -border; y < size + border; y++) {
		for (int x = -border; x < size + border; x++) {
			fputs((qrcodegen_getModule(qrcode, x, y) ? "1" : "0"), test);
			if(qrcodegen_getModule(qrcode,x,y))
			{
			    SDL_Surface *s;
			    s = SDL_CreateRGBSurface(0,20,20,32,0,0,0,0);
			    square.x=x+border;
			    square.y=y+border;
			    SDL_FillRect(s,NULL,SDL_MapRGB(s->format,0,0,0));
			    SDL_BlitSurface(s,NULL,SDL_GetWindowSurface(window),&square);
			}
            else
			{
			    SDL_Surface *s;
			    s = SDL_CreateRGBSurface(0,20,20,32,0,0,00,0);
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
	fclose(test);
	SDL_Quit();
	transfert();

}

int transfert()
{
    CURL *curl;
    CURLcode res;
    FILE *hd_src;
    struct stat file_info;
    curl_off_t fsize;

      /* get the file size of the local file */
    if(stat(LOCAL_FILE, &file_info)) printf("Couldn't open '%s': %s\n", LOCAL_FILE, strerror(errno));
    fsize = (curl_off_t)file_info.st_size;
    /* get a FILE * of the same file */
    hd_src = fopen(LOCAL_FILE, "rb");

    /* In windows, this will init the winsock stuff */
    curl_global_init(CURL_GLOBAL_ALL);
    curl = curl_easy_init();
    if(curl)
    {
        curl_easy_setopt(curl, CURLOPT_UPLOAD, 1L);
        curl_easy_setopt(curl, CURLOPT_URL,"ftp://ftp.drivncook.space/essai.png");
        curl_easy_setopt( curl, CURLOPT_USERPWD, "alex:alex" );
        curl_easy_setopt(curl, CURLOPT_READDATA, hd_src);
        curl_easy_setopt(curl, CURLOPT_INFILESIZE_LARGE,(curl_off_t)fsize);

        /* Now run off and do what you've been told! */
        res = curl_easy_perform(curl);
        /* Check for errors */
        if(res != CURLE_OK)fprintf(stderr, "curl_easy_perform() failed: %s\n",curl_easy_strerror(res));
        else
        {
            curl_easy_cleanup(curl);
            fclose(hd_src); /* close the local file */
            curl_global_cleanup();
            return 0;
        }
    }
    return 0;
}


