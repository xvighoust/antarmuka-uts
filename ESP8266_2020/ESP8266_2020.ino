#ifdef ESP32
#include <WiFi.h>
#include <HTTPClient.h>
#include <WiFiClient.h>
#else
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#endif

#include "DHT.h"

const char *ssid = "labalaba";
const char *password = "fromzerotohero";

//inisialisasi DHT
#define DHTPIN 2
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

// inisialisasi sensor api
int analogPin = 15;
int val = 0;
String val2 = "";

//inisialisasi PIR
int pir1 = 12;
String val6 = "";

//Insialisasi Asap
int mq2 = 0;
String val4 = "";




void setup() {
  dht.begin();
  delay(10);

  connectWifi();
}


void loop() {
  SendSensorData();
}


void connectWifi() {
  delay(1000);
  Serial.begin(115200);
  WiFi.mode(WIFI_OFF);        //mencegah masalah koneksi yang terlalu lama
  delay(1000);
  WiFi.mode(WIFI_STA);        //menjaga esp tidak terlihat sebagai hotspot
  WiFi.begin(ssid, password);
  Serial.println("");
  Serial.print("Connecting");

  //tunggu koneksi
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());  //IP address ESP kita
}



void SendSensorData() {
  HTTPClient http;
  String postData;
  //----------------------baca dht---------------------
  delay(1000);

  float suhu = 100;
  float kelembaban = 200;

  //----------------------baca API---------------------
  val = analogRead(analogPin);
  if (val < 100) {
    val2 = "Ada Api";
  }
  else {
    val2 = "Tidak Ada Api";
  }
  //----------------------baca ASAP---------------------
  int val3 = analogRead(mq2);
  if (val3 >= 320) {
    val4 = "Gas Terdeteksi";
  } else {
    val4 = "Gas Aman";
  }
  //----------------------baca PIR---------------------
  int val5 = digitalRead(pir1);

  if (val5 == HIGH) {
    val6 = "Ada Orang";
  } else {
    val6 = "Tidak Ada Orang";
  }
  //----------------------------------------------------

  if (isnan(suhu) || isnan(kelembaban) || isnan(val) || isnan(val3) || isnan(val5)) {
    Serial.println("Pembacaan Gagal");
    return;
  }

  Serial.print("Suhu : ");
  Serial.println(suhu);
  Serial.print("Kelembaban : ");
  Serial.println(kelembaban);
  Serial.print("Api : ");
  Serial.println(val2);
  Serial.print("Value Asap : ");
  Serial.println(val3);
  Serial.print("Final Asap : ");
  Serial.println(val4);
  Serial.print("Kondisi ");
  Serial.println(val6);

  String sensorData1 = String(suhu);
  String sensorData2 = String(kelembaban);
  String sensorData3 = String(val2);
  String sensorData4 = String(val4);
  String sensorData5 = String(val6);

  //Post Data
  //postData = "sensor1=" +  sensorData1 + "&sensor2=" + sensorData2 dan seterusnya;
  postData = "sensor1=" +  sensorData1 + "&sensor2=" + sensorData2 + "&sensor3=" + sensorData3 + "&sensor4=" + sensorData4 + "&sensor5=" + sensorData5;

  //masukkan IP server dan path program PHP
  http.begin("http://192.168.1.3/esp8266/postData.php");
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(postData);
  String payload = http.getString();

  Serial.println(httpCode);
  Serial.println(payload);

  http.end();

  delay(1000);
}
