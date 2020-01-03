package com.skripsi.marisonervan.adapter;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.skripsi.marisonervan.R;
import com.skripsi.marisonervan.model.ListHistoryScan;

import java.util.List;

public class HistoryScanAdapter extends BaseAdapter {

    private Activity activity;
    private LayoutInflater layoutInflater;
    private List<ListHistoryScan> listHistoryScans;

    public HistoryScanAdapter(Activity activity,List<ListHistoryScan> listHistoryScans){
        this.activity = activity;
        this.listHistoryScans = listHistoryScans;
    }
    @Override
    public int getCount() {
        return listHistoryScans.size();
    }

    @Override
    public Object getItem(int position) {
        return listHistoryScans.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (layoutInflater == null) layoutInflater = (LayoutInflater) activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        if (convertView == null) convertView = layoutInflater.inflate(R.layout.history_scan, null);

        TextView NoPolisi = (TextView) convertView.findViewById(R.id.noMobil);
        TextView TglHistory = (TextView) convertView.findViewById(R.id.tglHistory);

        ListHistoryScan l = listHistoryScans.get(position);

        NoPolisi.setText(l.getNoPolisi());
        TglHistory.setText(l.getTglCari());


        return convertView;
    }
}
