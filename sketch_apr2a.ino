#include <WiFi.h>
#include <WiFiClientSecure.h>
#include <HTTPClient.h>
#include <ESP32Servo.h>

const char* ssid = "Rumah"; 
const char* password = "11111111";
Servo sKering, sBasah; 

void setup() {
  Serial.begin(115200);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  sKering.attach(18); 
  sBasah.attach(19);
  sKering.write(0); 
  sBasah.write(0);
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClientSecure client;
    client.setInsecure();
    HTTPClient http;
    http.begin(client, "https://pakankucing.store/cek.php");    
    int kodehttp = http.GET();
    if (kodehttp == 200) {
      String tombol = http.getString();
      if (tombol == "kering") {
        sKering.write(90);
        delay(2000);
        sKering.write(0);
      } 
      else if (tombol == "basah") {
        sBasah.write(90);
        delay(2000);
        sBasah.write(0);
      }
    }
    http.end();
  } else {
    WiFi.reconnect(); 
  }
  delay(2000);
}