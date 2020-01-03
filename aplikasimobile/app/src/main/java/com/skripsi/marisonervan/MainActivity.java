package com.skripsi.marisonervan;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.GridView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.skripsi.marisonervan.adapter.MenuAdapter;
import com.skripsi.marisonervan.lapangan.Fpk_lapangan;
import com.skripsi.marisonervan.lapangan.History_lapangan;
import com.skripsi.marisonervan.manager.Fpk_manager;
import com.skripsi.marisonervan.manager.History_manager;
import com.skripsi.marisonervan.model.Menuutama;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class MainActivity extends AppCompatActivity {
    GridView gridView;

    String[] namaMenu={"SCAN","HISTORY SCAN","FPK","HISTORY FPK","NOTIFIKASI","SETTING","PROFIL","i-MANUAL","LOG-OUT"};
    int[] icon ={
            R.drawable.scan,
            R.drawable.history,
            R.drawable.fpk,
            R.drawable.historyfpk,
            R.drawable.notifikasi,
            R.drawable.setting,
            R.drawable.people,
            R.drawable.keyboard,
            R.drawable.logout
    };


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        CekKoneksi();
        gridView = (GridView) findViewById(R.id.gridview);
        MenuAdapter menuAdapter = new MenuAdapter(this,getMenu());
        gridView.setAdapter(menuAdapter);

        gridView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if (namaMenu[position].equals("SCAN")){
                    Intent intent = new Intent(getApplicationContext(), Scan.class);
                    startActivity(intent);
                }
                else if (namaMenu[position].equals("HISTORY SCAN")){
                    Intent intent = new Intent(getApplicationContext(), HistoryScan.class);
                    startActivity(intent);
                }
                else if (namaMenu[position].equals("FPK")){
                    String tipeUser = GetShared("tipe_user","tipeKey");
                    if(tipeUser.equals("slapangan")){
                        Intent intent = new Intent(getApplicationContext(), Fpk_lapangan.class);
                        startActivity(intent);
                    }else {
                        Intent intent = new Intent(getApplicationContext(), Fpk_manager.class);
                        startActivity(intent);
                    }
                }
                else if (namaMenu[position].equals("HISTORY FPK")){
                    String tipeUser = GetShared("tipe_user","tipeKey");
                    if(tipeUser.equals("slapangan")){
                        Intent intent = new Intent(getApplicationContext(), History_lapangan.class);
                        startActivity(intent);
                    }else {
                        Intent intent = new Intent(getApplicationContext(), History_manager.class);
                        startActivity(intent);
                    }
                }
                else if (namaMenu[position].equals("NOTIFIKASI")){
                    Intent intent = new Intent(getApplicationContext(),Notification.class);
                    startActivity(intent);
                }
                else if (namaMenu[position].equals("SETTING")){
                    Intent intent = new Intent(getApplicationContext(),Ubah_password.class);
                    startActivity(intent);
                }
                else if (namaMenu[position].equals("PROFIL")){
                    Intent intent = new Intent(getApplicationContext(),Profil.class);
                    startActivity(intent);
                }
                else if (namaMenu[position].equals("i-MANUAL")){
                    Intent intent = new Intent(getApplicationContext(),Manual.class);
                    startActivity(intent);
                }
                else if (namaMenu[position].equals("LOG-OUT")){
                    LogOut();
                }


            }
        });

    }
    private ArrayList<Menuutama> getMenu(){
        ArrayList<Menuutama> menuutamas = new ArrayList<Menuutama>();

        menuutamas.add(new Menuutama(namaMenu[0],icon[0]));
        menuutamas.add(new Menuutama(namaMenu[1],icon[1]));
        menuutamas.add(new Menuutama(namaMenu[2],icon[2]));
        menuutamas.add(new Menuutama(namaMenu[3],icon[3]));
        menuutamas.add(new Menuutama(namaMenu[4],icon[4]));
        menuutamas.add(new Menuutama(namaMenu[5],icon[5]));
        menuutamas.add(new Menuutama(namaMenu[6],icon[6]));
        menuutamas.add(new Menuutama(namaMenu[7],icon[7]));
        menuutamas.add(new Menuutama(namaMenu[8],icon[8]));
        return menuutamas;
    }


    private String GetShared(String Name, String Key){
        SharedPreferences settings = getSharedPreferences(Name, Context.MODE_PRIVATE);
        String data = settings.getString(Key,"");
        return data;
    }
    private void DeletePref(String prefname){
        String filePath = getApplicationContext().getFilesDir().getParent()+"/shared_prefs/"+prefname +".xml";
        File deletePrefFile = new File(filePath);
        System.out.println(deletePrefFile.delete());
    }
    @Override
    public void onBackPressed() {
        moveTaskToBack(true);
    }

    private void LogOut(){
        DeletePref("password");
        DeletePref("idUser");
        DeletePref("username");
        DeletePref("tipe_user");
        Intent intent = new Intent(getApplicationContext(),Login.class).setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
        startActivity(intent);
    }
    private void CekLogin(){
        if(GetShared("username","userKey").isEmpty()){
            Intent intent = new Intent(getApplicationContext(),Login.class).setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
        }
        else {
            final String username = GetShared("username","userKey");
            final String password = GetShared("password","pwdKey");
            StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_login,
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            try {
                                JSONObject jsonObject = new JSONObject(response);
                                if (jsonObject.getString("status").equals("gagal")){
                                    DeletePref("password");
                                    DeletePref("idUser");
                                    DeletePref("username");
                                    DeletePref("tipe_user");
                                    Toast.makeText(MainActivity.this,"Password Telah berubah", Toast.LENGTH_LONG).show();
                                    Intent intent = new Intent(getApplicationContext(),Login.class).setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                                    startActivity(intent);
                                }
                            }
                            catch (Exception e){
                                e.printStackTrace();
                            }
                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            // kalau datanya gk cocok
                            Intent intent = new Intent(getApplicationContext(),Login.class).setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                            startActivity(intent);
                        }
                    }
            ) {
                @Override
                public String getBodyContentType() {
                    return "application/x-www-form-urlencoded";
                }

                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("username", username);
                    params.put("password", password);
                    params.put("cekLogin", "CekLogin");
                    return params;
                }
            };
            RequestQueue requestQueue = Volley.newRequestQueue(this);
            requestQueue.add(stringRequest);
        }
    }
    private void CekKoneksi(){
            StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_login,
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            try {
                                JSONObject jsonObject = new JSONObject(response);
                                if (jsonObject.getString("status").equals("online")){
                                    CekLogin();
                                }
                            } catch (JSONException e) {
                                AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this);
                                builder.setTitle("! Alert");
                                builder.setMessage("Terjadi msalah saat menghubungi Server !");
                                builder.setNegativeButton("Keluar", new DialogInterface.OnClickListener() {
                                    @Override
                                    public void onClick(DialogInterface dialog, int which) {
                                        finish();
                                    }
                                });
                                builder.show();
                                e.printStackTrace();
                            }
                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this);
                            builder.setTitle("! Alert");
                            builder.setMessage("Terjadi msalah saat menghubungi Server !");
                            builder.setNegativeButton("Keluar", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialog, int which) {
                                    finish();
                                }
                            });
                            builder.show();
                        }
                    }
            ) {
                @Override
                public String getBodyContentType() {
                    return "application/x-www-form-urlencoded";
                }

                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("cekJaringan", "");
                    return params;
                }
            };
            RequestQueue requestQueue = Volley.newRequestQueue(this);
            requestQueue.add(stringRequest);
    }
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_main, menu);
        return super.onCreateOptionsMenu(menu);
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.about:
                Intent intent = new Intent(getApplicationContext(),About.class);
                startActivity(intent);
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

}
