package com.skripsi.marisonervan;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.skripsi.marisonervan.lapangan.History_lapangan;
import com.skripsi.marisonervan.manager.Fpk_manager;
import com.skripsi.marisonervan.manager.History_manager;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

public class Detail_fpk extends AppCompatActivity {
    private ProgressDialog progressDialog;
    Button Selesai,Tolak,Setujui;
    TextView TglPengajuan,NoPolisi,JenisPekerjaan,Keterangan;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_fpk);
        CekKoneksi();
        TglPengajuan = (TextView) findViewById(R.id.tglPengajuan);
        NoPolisi = (TextView) findViewById(R.id.noPolisi);
        JenisPekerjaan = (TextView) findViewById(R.id.jenisPekerjaan);
        Keterangan = (TextView) findViewById(R.id.keterangan);
        Selesai = (Button) findViewById(R.id.selesai);
        Tolak = (Button) findViewById(R.id.reject);
        Setujui = (Button) findViewById(R.id.approve);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Loading...");
        progressDialog.show();
        Bundle b = getIntent().getExtras();
        final String idFpk = b.getString("id_fpk");
        GetFpk(idFpk);

        Selesai.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Selesai(idFpk);
            }
        });
        Tolak.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Reject(idFpk);
            }
        });
        Setujui.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Approve(idFpk);
            }
        });

    }
    private void Reject(final String idFpk){
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_ajukanFpk,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            String status = jsonObject.getString("status");
                            hidePDialog();
                            if(status.equals("sukses")){
                                Toast.makeText(getApplicationContext(),"FPK DiTolak",Toast.LENGTH_SHORT).show();
                                Intent intent = new Intent(getApplicationContext(),Fpk_manager.class);
                                startActivity(intent);
                            }
                            else{
                                Toast.makeText(getApplicationContext(),"Gagal Menolak FPK",Toast.LENGTH_SHORT).show();
                                Intent intent = new Intent(getApplicationContext(),Fpk_manager.class);
                                startActivity(intent);
                            }
                        } catch (JSONException e) {
                            hidePDialog();
                            e.printStackTrace();
                        }

                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        hidePDialog();
                        System.out.println(error);
                    }
                }
        ) {
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("reject", idFpk);
                return params;
            }
        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }
    private void Approve(final String idFpk){
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_ajukanFpk,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            String status = jsonObject.getString("status");
                            hidePDialog();
                            if(status.equals("sukses")){
                                Toast.makeText(getApplicationContext(),"FPK Disetujui",Toast.LENGTH_SHORT).show();
                                Intent intent = new Intent(getApplicationContext(),Fpk_manager.class);
                                startActivity(intent);
                            }
                            else{
                                Toast.makeText(getApplicationContext(),"Gagal Menyetujui FPK",Toast.LENGTH_SHORT).show();
                                Intent intent = new Intent(getApplicationContext(),Fpk_manager.class);
                                startActivity(intent);
                            }
                        } catch (JSONException e) {
                            hidePDialog();
                            e.printStackTrace();
                        }

                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        hidePDialog();
                        System.out.println(error);
                    }
                }
        ) {
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("approve", idFpk);
                return params;
            }
        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }
    private void Selesai(final String idFpk){
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_ajukanFpk,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            String status = jsonObject.getString("status");
                            hidePDialog();
                            if(status.equals("sukses")){
                                Toast.makeText(getApplicationContext(),"FPK Selesai",Toast.LENGTH_SHORT).show();
                                Intent intent = new Intent(getApplicationContext(),History_lapangan.class);
                                startActivity(intent);
                            }
                            else{
                                Toast.makeText(getApplicationContext(),"Gagal menyelesaikan FPK",Toast.LENGTH_SHORT).show();
                                Intent intent = new Intent(getApplicationContext(),History_lapangan.class);
                                startActivity(intent);
                            }
                        } catch (JSONException e) {
                            hidePDialog();
                            e.printStackTrace();
                        }

                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        hidePDialog();
                        System.out.println(error);
                    }
                }
        ) {
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("selesai", idFpk);
                return params;
            }
        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }
    private String Tanggal(String tanggal) throws ParseException {
        SimpleDateFormat curFormater = new SimpleDateFormat("yyyy-MM-dd");
        Date dateObj = curFormater.parse(tanggal);
        SimpleDateFormat postFormater = new SimpleDateFormat("dd-MMM-yyyy");
        return postFormater.format(dateObj);
    }
    private void GetFpk(final String idFpk){
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_hisLapangan,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONArray jsonArray = new JSONArray(response);
                            for(int i=0; i< jsonArray.length();i++){
                                JSONObject jsonObject = jsonArray.getJSONObject(i);
                                TglPengajuan.setText(Tanggal(jsonObject.getString("tgl_pengajuan")));
                                NoPolisi.setText(jsonObject.getString("no_polisi"));
                                JenisPekerjaan.setText(jsonObject.getString("peruntukan"));
                                Keterangan.setText(jsonObject.getString("keterangan"));
                                if(GetShared("tipe_user","tipeKey").equals("slapangan")){
                                    Tolak.setVisibility(View.GONE);
                                    Setujui.setVisibility(View.GONE);
                                    if(jsonObject.getString("status_fpk").equals("approve")){
                                        Selesai.setVisibility(View.VISIBLE);
                                    }
                                    else {
                                        Selesai.setVisibility(View.GONE);
                                    }
                                }
                                else{

                                    Selesai.setVisibility(View.GONE);
                                    if(jsonObject.getString("status_fpk").equals("pending")){
                                        Tolak.setVisibility(View.VISIBLE);
                                        Tolak.setVisibility(View.VISIBLE);
                                    }
                                    else{
                                        Tolak.setVisibility(View.GONE);
                                        Setujui.setVisibility(View.GONE);
                                    }

                                }

                            }
                            hidePDialog();
                        } catch (JSONException e) {
                            hidePDialog();
                            e.printStackTrace();
                        } catch (ParseException e) {
                            e.printStackTrace();
                        }

                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        hidePDialog();
                        System.out.println(error);
                    }
                }
        ) {
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("idFpk", idFpk);
                return params;
            }
        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }
    private void hidePDialog() {
        if(progressDialog != null){
            progressDialog.dismiss();
            progressDialog = null;
        }
    }

    @Override
    public void onBackPressed() {
        if(GetShared("tipe_user","tipeKey").equals("slapangan")){
            Intent intent = new Intent(getApplicationContext(),History_lapangan.class);
            startActivity(intent);
        }
        else{
            Intent intent = new Intent(getApplicationContext(),History_manager.class);
            startActivity(intent);
        }
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
                                    Toast.makeText(getApplicationContext(),"Password Telah berubah", Toast.LENGTH_LONG).show();
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
                            AlertDialog.Builder builder = new AlertDialog.Builder(getApplicationContext());
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
                        AlertDialog.Builder builder = new AlertDialog.Builder(getApplicationContext());
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

}
