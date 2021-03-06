import React, { Component } from 'react';
import { Table } from 'react-bootstrap';
import { InternshipHits } from './InternshipHits';
import { ProjectHits } from './ProjectHits';

export class Results extends Component {

  getTable() {
    let jsx;

    if (this.props.indexName === 'internships') {
      jsx = (
        <Table striped bordered responsive>
          <thead>
            <tr>
              <th className="col col-md-4">Name</th>
              <th className="col col-md-4">Organization</th>
              <th className="col col-md-3">Availability</th>
              <th className="col col-md-1 text-center">Apply By</th>
            </tr>
          </thead>
          <InternshipHits indexName={this.props.indexName}
                userAccessAffiliations={this.props.userAccessAffiliations}
                canViewRestricted={this.props.canViewRestricted} />
        </Table>
      );
    } else {
      jsx = (
        <Table striped bordered responsive>
          <thead>
            <tr>
              <th className="col col-md-5 text-center">Name</th>
              <th className="col col-md-2 text-center">Availability</th>
              <th className="col col-md-2 text-center">City</th>
              <th className="col col-md-1 text-center">Begins</th>
              <th className="col col-md-1 text-center">Ends</th>
              <th className="col col-md-1 text-center">Apply By</th>
            </tr>
          </thead>
          <ProjectHits indexName={this.props.indexName}
                userAccessAffiliations={this.props.userAccessAffiliations}
                canViewRestricted={this.props.canViewRestricted} />
        </Table>
      );
    }

    return jsx;
  }

  render() {
    return <div>{this.getTable()}</div>;
  }
}
