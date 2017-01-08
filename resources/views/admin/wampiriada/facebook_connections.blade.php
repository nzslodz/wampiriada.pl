@extends('layouts.admin')

@section('title')
    Konkurs facebookowy
@stop

@section('content')
    <div class="page-header">
        <h2>Konkurs facebookowy &mdash; wyniki</h2>
    </div>

    <div id="graph">
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Osoba</th>
                <td class="info">Punkty</td>
                <td>Na akcji</td>
                <td>Poza akcją z</td>
            </tr>
        </thead>
        <tbody>

            @forelse($connections as $connection)
                <tr id="user-{{ $connection->getUser()->id }}">
                    <th>
                        <a data-card="{{ $connection->getUser()->id }}" href="{{ url('admin/activity/profile/'. $connection->getUser()->id) }}">{{ $connection->getUser()->getFullName() }}</a>

                        @if($connection->getUser()->facebook_user_id)
                            <small><a href="https://facebook.com/{{ $connection->getUser()->facebook_user_id }}">facebook</a></small>
                        @endif

                    </th>
                    <td class="info"><strong>{{ $connection->getScore() }}</strong></td>
                    <td>
                    <small>
                        @foreach($connection->getFriendCheckinsPresentOnActionIncludingMe() as $friend_checkin)
                            {{ $friend_checkin->friend_checkin->created_at->format('H:i') }}
                            @if(!$connection->isSelf($friend_checkin))
                            <a href="#user-{{ $friend_checkin->friend_checkin->user_id }}">
                            @endif
                                <em>{{ $friend_checkin->friend_checkin->user->getFullName() }}</em>
                            @if(!$connection->isSelf($friend_checkin))
                            </a>
                            @endif

                            <br>
                        @endforeach
                    </small>
                    </td>
                    <td>
                    <small>
                        @foreach($connection->getFriendCheckinsNotPresentOnAction() as $friend_checkin)
                            <a href="#user-{{ $friend_checkin->friend_checkin->user_id }}"><em>{{ $friend_checkin->friend_checkin->user->getFullName() }}</em></a><br>
                        @endforeach
                    </small>
                </tr>
            @empty
            <tr class="no-results">
                <td colspan="4">
                    Brak osób biorących udział w konkursie.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
@stop

@section('extrahead')
<style tyle="text/css">

    .node {
        font-size: 11px;
    }

    .link {
        stroke: steelblue;
        stroke-opacity: .3;
        fill: none;
    }

    .link2 {
        stroke: green;
        stroke-opacity: .3;
        fill: none;
    }


</style>
@stop

@section('script')
    <script src="//d3js.org/d3.v3.min.js"></script>
    <script type="text/javascript">
        var nodes = [
            @foreach($connections_by_action as $timestamp => $list)
                {'children': [

                    @foreach($list as $connection)
                {
                    'id': {{ $connection->getUser()->id }},
                    'name': '{{ $connection->getUser()->getFullName() }}',
                    'action_day_id': {{ $connection->getCheckin()->action_day_id }},
                    'friends': [
                        @foreach($connection->getFriendCheckins() as $friend_checkin)
                            {
                                'id': {{ $friend_checkin->friend_checkin->user_id }},
                            },
                        @endforeach
                    ]
                },
                @endforeach

                ]},
            @endforeach
        ]


        var diameter = 2200,
            radius = diameter / 2,
            innerRadius = radius - 120;

        var cluster = d3.layout.cluster()
            .size([360, innerRadius])
            .sort(function(a, b) {
                return d3.ascending(a.name, b.name)
            })

        var bundle = d3.layout.bundle();

        var line = d3.svg.line.radial()
            .interpolate("bundle")
            .tension(.85)
            .radius(function(d) { return d.y; })
            .angle(function(d) { return d.x / 180 * Math.PI; });

        var svg = d3.select("#graph").append("svg")
            .attr("width", diameter)
            .attr("height", diameter)
          .append("g")
            .attr("transform", "translate(" + radius + "," + radius + ")");

          var nodes = cluster.nodes({'children': nodes});
          var links = packageImports(nodes);

          console.log("nodes", nodes)
          console.log("links", links)

          svg.selectAll(".link")
              .data(bundle(links))
            .enter().append("path")
              .attr("class", function(d) { return (d[0].action_day_id == d[d.length - 1].action_day_id) ? "link": "link2" })
              .attr("d", line);

          svg.selectAll(".node")
              .data(nodes)
            .enter().append("g")
              .attr("class", "node")
              .attr("transform", function(d) { return "rotate(" + (d.x - 90) + ")translate(" + d.y + ")"; })
            .append("text")
              .attr("dx", function(d) { return d.x < 180 ? 8 : -8; })
              .attr("dy", ".31em")
              .attr("text-anchor", function(d) { return d.x < 180 ? "start" : "end"; })
              .attr("transform", function(d) { return d.x < 180 ? null : "rotate(180)"; })
              .text(function(d) { return d.name; });

        // Return a list of imports for the given array of nodes.
        function packageImports(nodes) {
          var map = {},
              imports = [];

          // Compute a map from name to node.
          nodes.forEach(function(d) {
            map[d.id] = d;
          });

          // For each import, construct a link from the source to target node.
          nodes.forEach(function(d) {
            if (d.friends) d.friends.forEach(function(i) {
              imports.push({source: map[d.id], target: map[i.id]});
            });
          });

          return imports;
        }
    </script>
@stop
