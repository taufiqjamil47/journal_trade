//+------------------------------------------------------------------+
//|                                          LaravelTradeBridge.mq5  |
//|                                    Copyright 2026, Your Company  |
//+------------------------------------------------------------------+
#property copyright "Copyright 2026, Your Company"
#property link      "https://your.com"
#property version   "1.02"

//+------------------------------------------------------------------+
//| INPUT PARAMETERS                                                 |
//+------------------------------------------------------------------+
input string   WebhookURL     = "http://127.0.0.1:8000/api/mt5/webhook"; // Webhook URL
input int      LaravelAccountId = 7;  // 🔥 ID Account di Laravel
input bool     SendOnTimer    = true;     // Kirim data setiap interval
input int      TimerInterval  = 60;       // Interval dalam detik (min 5)
input bool     SendOnTrade    = true;     // Kirim saat ada perubahan trade
input bool     IncludeHistory = true;     // Sertakan history tertutup
input int      HistoryDays    = 30;       // Jumlah hari history yang diambil
input bool     DebugMode      = true;     // Tampilkan log di terminal

//+------------------------------------------------------------------+
//| GLOBAL VARIABLES                                                 |
//+------------------------------------------------------------------+
datetime LastSyncTime = 0;
datetime LastTradeCheck = 0;
ulong    LastTicket = 0;
int      TimerSeconds = 60;

//+------------------------------------------------------------------+
//| Expert initialization function                                   |
//+------------------------------------------------------------------+
int OnInit()
{
   // Validate Webhook URL
   if(StringLen(WebhookURL) < 10)
   {
      Print("ERROR: Webhook URL tidak valid!");
      return(INIT_FAILED);
   }
   
   // Set timer interval
   TimerSeconds = TimerInterval;
   if(TimerSeconds < 5)
   {
      Print("WARNING: Timer interval too low. Setting to minimum 5 seconds.");
      TimerSeconds = 5;
   }
   
   Print("=== LARAVEL TRADE BRIDGE EA ===");
   Print("Webhook URL: ", WebhookURL);
   Print("Account ID: ", AccountInfoInteger(ACCOUNT_LOGIN));
   Print("Send on timer: ", SendOnTimer ? "Yes" : "No");
   Print("Send on trade change: ", SendOnTrade ? "Yes" : "No");
   Print("Include history: ", IncludeHistory ? "Yes" : "No");
   Print("Timer interval: ", TimerSeconds, " seconds");
   Print("=================================");
   
   if(SendOnTimer)
      EventSetTimer(TimerSeconds);
   
   // Kirim data pertama kali
   if(IncludeHistory)
      SendAllTradesData();
   else
      SendOpenPositionsData();
   
   return(INIT_SUCCEEDED);
}

//+------------------------------------------------------------------+
//| Expert deinitialization function                                 |
//+------------------------------------------------------------------+
void OnDeinit(const int reason)
{
   if(SendOnTimer)
      EventKillTimer();
   Print("EA deinitialized. Reason: ", reason);
}

//+------------------------------------------------------------------+
//| Timer function                                                   |
//+------------------------------------------------------------------+
void OnTimer()
{
   if(!SendOnTimer) return;
   
   if(SendOnTrade)
   {
      if(CheckTradeChanged())
      {
         if(DebugMode) Print("Trade change detected, sending data...");
         SendAllTradesData();
      }
   }
   else
   {
      SendAllTradesData();
   }
}

//+------------------------------------------------------------------+
//| Cek apakah ada perubahan pada posisi                             |
//+------------------------------------------------------------------+
bool CheckTradeChanged()
{
   int totalPositions = PositionsTotal();
   ulong currentTicket = 0;
   bool ticketChanged = false;
   
   for(int i = 0; i < totalPositions; i++)
   {
      ulong ticket = PositionGetTicket(i);
      if(ticket > 0 && ticket != LastTicket)
      {
         ticketChanged = true;
         LastTicket = ticket;
         break;
      }
   }
   
   if(!ticketChanged)
   {
      if(HistorySelect(TimeCurrent() - 86400, TimeCurrent()))
      {
         int totalHistory = HistoryDealsTotal();
         if(totalHistory > 0)
         {
            ulong dealTicket = HistoryDealGetTicket(totalHistory - 1);
            if(dealTicket > 0 && dealTicket != LastTicket)
            {
               ticketChanged = true;
               LastTicket = dealTicket;
            }
         }
      }
   }
   
   return ticketChanged;
}

//+------------------------------------------------------------------+
//| Send semua data trades                                           |
//+------------------------------------------------------------------+
void SendAllTradesData()
{
   string json = BuildTradesJson();
   if(DebugMode) Print("JSON length: ", StringLen(json));
   SendWebhook(json);
}

//+------------------------------------------------------------------+
//| Kirim hanya posisi terbuka                                       |
//+------------------------------------------------------------------+
void SendOpenPositionsData()
{
   string json = BuildOpenPositionsJson();
   SendWebhook(json);
}

//+------------------------------------------------------------------+
//| Build JSON untuk open positions                                  |
//+------------------------------------------------------------------+
string BuildOpenPositionsJson()
{
   string result = "[";
   int total = PositionsTotal();
   int count = 0;
   
   for(int i = 0; i < total; i++)
   {
      ulong ticket = PositionGetTicket(i);
      if(PositionSelectByTicket(ticket))
      {
         string tradeJson = BuildTradeJson(ticket, true);
         if(tradeJson != "")
         {
            if(count > 0) result += ",";
            result += tradeJson;
            count++;
         }
      }
   }
   
   result += "]";
   return result;
}

//+------------------------------------------------------------------+
//| Build JSON untuk semua trades (open + history)                  |
//+------------------------------------------------------------------+
string BuildTradesJson()
{
   string result = "[";
   int count = 0;
   
   // 1. Ambil posisi terbuka
   int totalOpen = PositionsTotal();
   for(int i = 0; i < totalOpen; i++)
   {
      ulong ticket = PositionGetTicket(i);
      if(PositionSelectByTicket(ticket))
      {
         string tradeJson = BuildTradeJson(ticket, true);
         if(tradeJson != "")
         {
            if(count > 0) result += ",";
            result += tradeJson;
            count++;
         }
      }
   }
   
   // 2. Ambil history
   if(IncludeHistory)
   {
      datetime fromDate = TimeCurrent() - (HistoryDays * 86400);
      datetime toDate = TimeCurrent();
      
      if(HistorySelect(fromDate, toDate))
      {
         int totalDeals = HistoryDealsTotal();
         for(int i = totalDeals - 1; i >= 0; i--)
         {
            ulong dealTicket = HistoryDealGetTicket(i);
            if(dealTicket > 0)
            {
               ENUM_DEAL_ENTRY entryType = (ENUM_DEAL_ENTRY)HistoryDealGetInteger(dealTicket, DEAL_ENTRY);
               if(entryType == DEAL_ENTRY_OUT || entryType == DEAL_ENTRY_INOUT)
               {
                  string tradeJson = BuildHistoryTradeJson(dealTicket);
                  if(tradeJson != "")
                  {
                     if(count > 0) result += ",";
                     result += tradeJson;
                     count++;
                  }
               }
            }
         }
      }
   }
   
   result += "]";
   return result;
}

//+------------------------------------------------------------------+
//| Build JSON untuk satu posisi terbuka                             |
//+------------------------------------------------------------------+
string BuildTradeJson(ulong ticket, bool isOpen)
{
   string json = "";
   
   if(!PositionSelectByTicket(ticket))
      return json;
   
   string symbol      = PositionGetString(POSITION_SYMBOL);
   ENUM_POSITION_TYPE type = (ENUM_POSITION_TYPE)PositionGetInteger(POSITION_TYPE);
   double entry       = PositionGetDouble(POSITION_PRICE_OPEN);
   double stopLoss    = PositionGetDouble(POSITION_SL);
   double takeProfit  = PositionGetDouble(POSITION_TP);
   double currentPrice = PositionGetDouble(POSITION_PRICE_CURRENT);
   double profit      = PositionGetDouble(POSITION_PROFIT);
   double volume      = PositionGetDouble(POSITION_VOLUME);
   datetime openTime  = (datetime)PositionGetInteger(POSITION_TIME);
   string comment     = PositionGetString(POSITION_COMMENT);
   
   double exit = currentPrice;
   double profitLoss = NormalizeDouble(profit, 2);
   double lotSize = NormalizeDouble(volume, 2);
   
   json = "{";
   json += "\"mt5ticket\":\"" + (string)ticket + "\",";
   json += "\"symbol\":\"" + symbol + "\",";
   json += "\"type\":\"" + (type == POSITION_TYPE_BUY ? "buy" : "sell") + "\",";
   json += "\"entry\":" + DoubleToString(entry, 5) + ",";
   json += "\"stop_loss\":" + DoubleToString(stopLoss, 5) + ",";
   json += "\"take_profit\":" + DoubleToString(takeProfit, 5) + ",";
   json += "\"exit\":" + DoubleToString(exit, 5) + ",";
   json += "\"timestamp\":\"" + TimeToString(openTime, TIME_DATE|TIME_SECONDS) + "\",";
   json += "\"profit_loss\":" + DoubleToString(profitLoss, 2) + ",";
   json += "\"lot_size\":" + DoubleToString(lotSize, 2) + ",";
   json += "\"mt5_comment\":\"" + comment + "\"";
   json += "}";
   
   return json;
}

//+------------------------------------------------------------------+
//| Build JSON untuk history trade                                   |
//+------------------------------------------------------------------+
string BuildHistoryTradeJson(ulong dealTicket)
{
   string json = "";
   
   if(!HistoryDealSelect(dealTicket))
      return json;
   
   string symbol      = HistoryDealGetString(dealTicket, DEAL_SYMBOL);
   ENUM_DEAL_ENTRY entryType = (ENUM_DEAL_ENTRY)HistoryDealGetInteger(dealTicket, DEAL_ENTRY);
   double price       = HistoryDealGetDouble(dealTicket, DEAL_PRICE);
   double volume      = HistoryDealGetDouble(dealTicket, DEAL_VOLUME);
   double profit      = HistoryDealGetDouble(dealTicket, DEAL_PROFIT);
   datetime time      = (datetime)HistoryDealGetInteger(dealTicket, DEAL_TIME);
   string comment     = HistoryDealGetString(dealTicket, DEAL_COMMENT);
   ulong positionId   = HistoryDealGetInteger(dealTicket, DEAL_POSITION_ID);
   
   if(entryType == DEAL_ENTRY_IN || entryType == DEAL_ENTRY_INOUT)
      return "";
   
   double entry = 0;
   datetime openTime = time;
   string positionType = "sell";
   
   if(HistorySelect(TimeCurrent() - (HistoryDays * 86400), TimeCurrent()))
   {
      int totalDeals = HistoryDealsTotal();
      for(int i = 0; i < totalDeals; i++)
      {
         ulong tempTicket = HistoryDealGetTicket(i);
         if(tempTicket > 0 && tempTicket != dealTicket)
         {
            if(HistoryDealGetInteger(tempTicket, DEAL_POSITION_ID) == positionId)
            {
               ENUM_DEAL_ENTRY tempEntry = (ENUM_DEAL_ENTRY)HistoryDealGetInteger(tempTicket, DEAL_ENTRY);
               if(tempEntry == DEAL_ENTRY_IN)
               {
                  entry = HistoryDealGetDouble(tempTicket, DEAL_PRICE);
                  openTime = (datetime)HistoryDealGetInteger(tempTicket, DEAL_TIME);
                  positionType = (price > entry) ? "buy" : "sell";
                  break;
               }
            }
         }
      }
   }
   
   if(entry == 0)
      entry = price;
   
   double lotSize = NormalizeDouble(volume, 2);
   double profitLoss = NormalizeDouble(profit, 2);
   double exit = price;
   
   json = "{";
   json += "\"mt5ticket\":\"" + (string)dealTicket + "\",";
   json += "\"symbol\":\"" + symbol + "\",";
   json += "\"type\":\"" + positionType + "\",";
   json += "\"entry\":" + DoubleToString(entry, 5) + ",";
   json += "\"stop_loss\":0,";
   json += "\"take_profit\":0,";
   json += "\"exit\":" + DoubleToString(exit, 5) + ",";
   json += "\"timestamp\":\"" + TimeToString(openTime, TIME_DATE|TIME_SECONDS) + "\",";
   json += "\"profit_loss\":" + DoubleToString(profitLoss, 2) + ",";
   json += "\"lot_size\":" + DoubleToString(lotSize, 2) + ",";
   json += "\"mt5_comment\":\"" + comment + "\"";
   json += "}";
   
   return json;
}

//+------------------------------------------------------------------+
//| Send Webhook - HTTP POST request (UPDATED)                       |
//+------------------------------------------------------------------+
void SendWebhook(string jsonData)
{
   if(DebugMode)
   {
      Print("Sending data to webhook...");
   }
   
   // Hapus null terminator
   StringReplace(jsonData, "\0", "");
   
   long accountId = AccountInfoInteger(ACCOUNT_LOGIN);
   string payload = StringFormat(
      "{\"account_id\":%d,\"trades\":%s}",
      LaravelAccountId,  // Gunakan ID dari parameter input
      jsonData
   );
   
   StringReplace(payload, "\0", "");
   
   if(DebugMode)
   {
      string preview = payload;
      if(StringLen(preview) > 300)
         preview = StringSubstr(preview, 0, 300) + "... (truncated)";
      Print("Payload preview: ", preview);
      Print("Laravel Account ID: ", LaravelAccountId);
      Print("Payload length: ", StringLen(payload));
   }
   
   string headers = "Content-Type: application/json\r\n";
   headers += "Accept: application/json\r\n";
   headers += "Content-Length: " + (string)StringLen(payload) + "\r\n";
   
   char data[];
   int dataSize = StringToCharArray(payload, data, 0, WHOLE_ARRAY, CP_UTF8);
   
   if(dataSize <= 0)
   {
      Print("ERROR: Failed to convert payload to char array!");
      return;
   }
   
   char result[];
   string resultHeaders;
   
   // 🔥 FIX: Tambah timeout menjadi 30 detik (default 5000ms)
   int timeout = 30000;  // 30 detik
   
   int res = WebRequest("POST", WebhookURL, headers, timeout, data, result, resultHeaders);
   
   if(res == 200)
   {
      string response = CharArrayToString(result, 0, -1, CP_UTF8);
      if(DebugMode) Print("✅ Webhook sent successfully. Response: ", response);
      else Print("✅ Webhook sent successfully.");
   }
   else if(res == -1)
   {
      int error = GetLastError();
      Print("❌ Webhook failed. Error: ", error);
      
      if(error == 1003)
         Print("   Error 1003: Timeout - Data terlalu besar atau server terlalu lambat.");
      else if(error == 4014)
         Print("   Error 4014: URL tidak di-allow di MetaEditor.");
   }
   else
   {
      string response = CharArrayToString(result, 0, -1, CP_UTF8);
      Print("❌ Webhook returned status: ", res);
      if(StringLen(response) > 0)
         Print("   Response: ", response);
   }
}

//+------------------------------------------------------------------+
//| Chart event handler                                              |
//+------------------------------------------------------------------+
void OnChartEvent(const int id, const long &lparam, const double &dparam, const string &sparam)
{
   if(id == CHARTEVENT_KEYDOWN)
   {
      if(sparam == "s") // Tombol 's' untuk sync manual
      {
         Print("Manual sync triggered by user (key 's')");
         SendAllTradesData();
      }
   }
}
//+------------------------------------------------------------------+