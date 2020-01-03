package com.skripsi.marisonervan.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.skripsi.marisonervan.R;
import com.skripsi.marisonervan.model.Menuutama;

import java.util.ArrayList;


public class MenuAdapter extends BaseAdapter {
    LayoutInflater inflater;
    Context context;
    ArrayList<Menuutama> menuutamas;

    public MenuAdapter(Context context, ArrayList<Menuutama> menuutamas){
        this.context = context;
        this.menuutamas = menuutamas;
    }
    @Override
    public int getCount() {
        return menuutamas.size();
    }

    @Override
    public Object getItem(int position) {
        return menuutamas.get(position);
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        if (inflater == null) inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        if (convertView == null) convertView = inflater.inflate(R.layout.menu_adapter, null);

        ImageView imageView = (ImageView) convertView.findViewById(R.id.icon);
        TextView textView = (TextView) convertView.findViewById(R.id.namaMenu);

        imageView.setImageResource(menuutamas.get(position).getIcon());
        textView.setText(menuutamas.get(position).getNamaMenu());
        return convertView;
    }
}
