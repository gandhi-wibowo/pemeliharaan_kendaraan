package com.skripsi.marisonervan;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.Volley;
import com.skripsi.marisonervan.lapangan.Fpk_lapangan;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class Manual extends AppCompatActivity {
    Button lihatdetail;
    AutoCompleteTextView nokendaraan;
    ArrayList<String> noPol = new ArrayList<String>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_manual);

        lihatdetail=(Button) findViewById(R.id.manual);
        nokendaraan=(AutoCompleteTextView) findViewById(R.id.noPolisi);


        GetNopol();
        lihatdetail.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Bundle b = new Bundle();
                b.putString("noMobil", nokendaraan.getText().toString());
                Intent intent = new Intent(getApplicationContext(), Detail.class);
                intent.putExtras(b);
                startActivity(intent);

            }
        });

    }
    private void GetNopol(){
        JsonArrayRequest mobilReq = new JsonArrayRequest(Constant.url_nopol,
                new Response.Listener<JSONArray>() {
                    @Override
                    public void onResponse(JSONArray response) {
                        try {

                            for(int i=0; i< response.length();i++){
                                JSONObject jsonObject = response.getJSONObject(i);
                                String nomor = jsonObject.getString("no_polisi");
                                noPol.add(i,nomor);
                            }

                            ArrayAdapter<String> noPolisi = new ArrayAdapter<String>(getApplicationContext(),R.layout.spinner_dropdown_item, noPol);

                            nokendaraan.setThreshold(2);
                            nokendaraan.setAdapter(noPolisi);

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }

                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {


            }
        });
        RequestQueue mRequestQueue  = Volley.newRequestQueue(getApplicationContext());
        mRequestQueue.add(mobilReq);
    }
}
